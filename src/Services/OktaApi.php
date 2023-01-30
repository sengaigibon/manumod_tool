<?php
namespace App\Services;

use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class OktaApi
{
    private SessionInterface $session;
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;
    private string $oktaUrl;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
        $this->clientId     = $_ENV['OKTA_OAUTH2_CLIENT_ID'];
        $this->clientSecret = $_ENV['OKTA_OAUTH2_CLIENT_SECRET'];
        $this->redirectUri  = $_ENV['OKTA_OAUTH2_REDIRECT_URI'];
        $this->oktaUrl  = $_ENV['OKTA_OAUTH2_ISSUER'];
    }

    public function buildAuthorizeUrl(): string
    {
        // Generate a random state parameter for CSRF security
        $this->session->set('oauth_state', bin2hex(random_bytes(10)));

        // Create the PKCE code verifier and code challenge
        $codeVerifier = bin2hex(random_bytes(50));
        $this->session->set('oauth_code_verifier', $codeVerifier);
        $hash = hash('sha256', $codeVerifier, true);
        $codeChallenge = rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');

        // Build the authorization URL by starting with the authorization endpoint
        return $this->oktaUrl . '/v1/authorize?' . http_build_query([
                'client_id' => $this->clientId,
                'code_challenge' => $codeChallenge,
                'code_challenge_method' => 'S256',
                'redirect_uri' => $this->redirectUri,
                'response_type' => 'code',
                'scope' => 'openid profile email',
                'state' => $this->session->get('oauth_state'),
            ]);
    }

    public function authorizeUser()
    {
        if (empty($_GET['state']) || $_GET['state'] != $this->session->get('oauth_state')) {
            throw new Exception("state does not match");
        }

        if(!empty($_GET['error'])) {
            throw new Exception("authorization server returned an error: " . $_GET['error']);
        }

        if(empty($_GET['code'])) {
            throw new Exception("this is unexpected, the authorization server redirected without a code or an  error");
        }

        $response = $this->httpRequest($this->oktaUrl . '/v1/token?', [
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'code_verifier' => $this->session->get('oauth_code_verifier'),
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ]);

        if (isset($response['error'])) {
            throw new Exception("token endpoint returned an error: " . $response['error']);
        }

        if (!isset($response['access_token'])) {
            throw new Exception("token endpoint did not return an error or an access token");
        }

        // Save the tokens in the session
        $this->session->set('okta_access_token', $response['access_token']);

        if (isset($response['refresh_token'])) {
            $this->session->set($response['okta_refresh_token'], $response['refresh_token']);
        }

        if (isset($response['id_token'])) {
            $this->session->set('okta_id_token', $response['id_token']);
        }

        $claims = json_decode(base64_decode(explode('.', $response['id_token'])[1]));

        return $claims;
    }

    private function httpRequest(string $url, ?array $params = null): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($params) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        return json_decode(curl_exec($ch), true);
    }
}
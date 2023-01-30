use datacenter;

drop view if exists modelsRelations;

create view modelsRelations as
select concat(mkh.id,parentModel.id,childModel.id) as id, mkh.name as manufacturerName, parentModel.id as parentId, parentModel.name as parentName, childModel.id as childId, childModel.name as modelName
from mdx_kfz_model_parent parentTable
    join mdx_kfz_models parentModel on parentTable.parentModelId = parentModel.id
    join mdx_kfz_models childModel on parentTable.modelId = childModel.id
    join mdx_kfz_herst mkh on parentModel.herst = mkh.id
order by mkh.id, parentModel.name, childModel.name;

select parentModel.name, childModel.name
from mdx_kfz_model_parent parentTable, mdx_kfz_models parentModel, mdx_kfz_models childModel
where parentTable.parentModelId = parentModel.id and parentTable.modelId = childModel.id
order by parentTable.parentModelId;

select * from modelsRelations;
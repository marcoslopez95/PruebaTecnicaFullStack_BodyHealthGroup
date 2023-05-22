import { FieldsBaseModel, IsDeletedField } from "../Base.model"
import { Publication } from "./Publication.model"

export declare interface PublicationCreate extends Omit<Publication, FieldsBaseModel | OmitsFields> {
    region_id: number | ''
    publication_category_id: number | ''
    external_references: number[]
}

export declare interface PublicationUpdate extends Omit<Publication, IsDeletedField | OmitsFields> {
    region_id: number | ''
    publication_category_id: number | ''
    external_references: number[]
}

type OmitsFields =  'region'
| 'external_references'
| 'publication_category'
| 'created_at'

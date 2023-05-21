export default interface BaseModel {
    id: number
    isDeleted?: boolean
}

export type FieldsBaseModel = keyof BaseModel
export type IsDeletedField = 'isDeleted'

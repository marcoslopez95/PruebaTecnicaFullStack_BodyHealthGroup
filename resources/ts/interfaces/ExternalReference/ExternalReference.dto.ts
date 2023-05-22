import { FieldsBaseModel, IsDeletedField } from "../Base.model";
import { ExternalReference } from "./ExternalReference.model";

export declare interface ExternalReferenceCreate extends Omit<ExternalReference,FieldsBaseModel>{}
export declare interface ExternalReferenceUpdate extends Omit<ExternalReference,IsDeletedField>{}

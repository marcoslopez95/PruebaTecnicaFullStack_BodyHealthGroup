import BaseModel, { IsDeletedField } from "../Base.model";
import { PublicationCategory } from "./PublicationCategory.model";

export declare interface PublicationCategoryCreate extends Omit<PublicationCategory, keyof BaseModel> {}

export declare interface PublicationCategoryUpdate extends Omit<PublicationCategory,IsDeletedField>{}

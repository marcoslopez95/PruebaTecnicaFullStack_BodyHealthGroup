import BaseModel from "../Base.model";
import { ExternalReference } from "../ExternalReference/ExternalReference.model";
import { PublicationCategory } from "../PublicationCategory/PublicationCategory.model";
import { Region } from "../Region/Region.model";

export declare interface Publication extends BaseModel {
    content: string
    labels: string[]
    created_at: Date
    region: Region
    external_references: ExternalReference[]
    publication_category: PublicationCategory
}

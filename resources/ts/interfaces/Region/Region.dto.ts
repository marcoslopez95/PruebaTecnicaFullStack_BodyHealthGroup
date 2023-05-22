import BaseModel from "../Base.model";
import { Region } from "./Region.model";

export declare interface RegionCreate extends Omit<Region, keyof BaseModel>{}
export declare interface RegionUpdate extends Omit<Region, 'isDeleted'>{}

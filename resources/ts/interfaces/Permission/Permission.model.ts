import BaseModel from "../Base.model";

export declare interface Permission extends BaseModel{
    name: string
    guard_name: string
}

import BaseModel from "../Base.model";
import { Permission } from "../Permission/Permission.model";

export declare interface Role extends BaseModel {
    name: string
    guard_name: string
    permissions: Permission[]
}

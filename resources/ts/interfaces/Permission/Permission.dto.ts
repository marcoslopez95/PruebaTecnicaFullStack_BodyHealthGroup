import BaseModel from "../Base.model";
import { Permission } from "./Permission.model";

export declare interface PermissionCreate extends ignoreFields{
    name: string
    guard_name: string
}
export declare interface PermissionUpdate extends Permission{}

type ignoreFields = Omit<Permission, keyof BaseModel>

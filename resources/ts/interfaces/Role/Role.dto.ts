import BaseModel from "../Base.model";
import { Role } from "./Role.model";

export declare interface RoleCreate extends ignoreFields{
    name: string
    guard_name: string
    permissions: number[]
}
export declare interface RoleUpdate extends Omit<Role, 'permissions'>{
    permissions: number[]
}

type ignoreFields = Omit<Role, keyof BaseModel | 'permissions'>

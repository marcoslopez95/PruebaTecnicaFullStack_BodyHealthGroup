import BaseModel from "../Base.model";
import { Role } from "../Role/Role.model";

export declare interface User extends BaseModel{
    name: string
    email: string
    created_at: Date
    role: Role
}

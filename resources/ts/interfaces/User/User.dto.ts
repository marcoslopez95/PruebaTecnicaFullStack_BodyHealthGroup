import BaseModel from "../Base.model";
import { User } from "./User.model";

export declare interface UserCreate extends ignoreField {
    name: string
    email: string
    role_id: number
    password: string
    password_confirmation: string
}

export declare interface UserUpdate extends Omit<User,'role'> {
    name: string
    email: string
    role_id: number
    password?: string
    password_confirmation?: string
}
type ignoreField = Omit<User, keyof BaseModel | 'role'>

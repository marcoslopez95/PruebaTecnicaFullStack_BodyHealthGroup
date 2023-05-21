import { helperStore } from "@/helper";
import { defineStore } from "pinia";
import { Permission } from "resources/ts/interfaces/Permission/Permission.model";
import { ref } from "vue";
export const PermissionStore = defineStore('Permission', () => {
    const helper = helperStore()

    const permissions = ref<Permission[]>([])
    const getPermissions = () =>{
        helper
            .http('/api/v1/admin/security/permissions')
            .then((res:any) => {
                permissions.value = res.data.data as Permission[]
            })
    }
    return {
        getPermissions,
        permissions
    }
})

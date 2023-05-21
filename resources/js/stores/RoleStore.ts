import { defineStore, storeToRefs } from 'pinia'
import { PermissionStore } from './PermissionStore'
import { ref } from 'vue'
import { RoleCreate } from 'resources/ts/interfaces/Role/Role.dto'

export const RoleStore = defineStore('role', () => {
  const permissionsStore = PermissionStore()
  const { permissions } = storeToRefs(permissionsStore)
  const { getPermissions } = permissionsStore

  const form = ref<RoleCreate>({
    name: '',
    guard_name: '',
    permissions: []
})
  return {
    permissions,
    getPermissions,
    form
  }
})

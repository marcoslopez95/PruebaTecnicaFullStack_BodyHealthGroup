import { helperStore } from '@/helper'
import { defineStore } from 'pinia'
import {
  PermissionCreate,
  PermissionUpdate,
} from 'resources/ts/interfaces/Permission/Permission.dto'
import { Permission } from 'resources/ts/interfaces/Permission/Permission.model'
import { ref } from 'vue'
export const PermissionStore = defineStore('Permission', () => {
  const helper = helperStore()

  const permissions = ref<Permission[]>([])
  const getPermissions = () => {
    helper.http('/api/v1/admin/security/permissions').then((res: any) => {
      permissions.value = res.data.data as Permission[]
    })
  }
  const form = ref<PermissionCreate | PermissionUpdate>({
    name: '',
    guard_name: '',
  })

  const resetForm = () => {
    form.value = {
      name: '',
      guard_name: '',
    }
  }
  return {
    getPermissions,
    permissions,
    form,
    resetForm,
  }
})

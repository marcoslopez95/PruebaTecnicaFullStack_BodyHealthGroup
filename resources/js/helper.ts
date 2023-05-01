import { defineStore } from 'pinia'
import { ref } from 'vue'
export const helperStore = defineStore('helper',() => {
    const openHamburgerMenu = ref(false)

    return {
        openHamburgerMenu
    }
})

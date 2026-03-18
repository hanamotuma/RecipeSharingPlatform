import { ref } from 'vue'

const notifications = ref([])

export function useNotification() {
    const show = ({ type = 'info', title = 'Notification', message, duration = 5000 }) => {
        const id = Date.now()
        notifications.value.push({ id, type, title, message, duration })
        
        setTimeout(() => {
            remove(id)
        }, duration)
    }

    const remove = (id) => {
        const index = notifications.value.findIndex(n => n.id === id)
        if (index !== -1) {
            notifications.value.splice(index, 1)
        }
    }

    return {
        notifications,
        show,
        remove
    }
}
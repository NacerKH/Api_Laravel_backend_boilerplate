import axios from "axios";
import { ref } from "vue";
import { useNotification } from "@kyvg/vue3-notification";
import axiosClient from "@/axios";

const { notify } = useNotification()


export default function useCrudUserService() {

    const users = ref([]);
    const getUsers = async () => {
        try {
        let response = await   axiosClient.get('/admin/users');
        console.log(response.data.data)
            users.value=response.data.data;
        } catch (e) {

            console.log(e.response.status)

        }

    }



return {

    users,
    getUsers
}


}

import store from "@/store";
import { setCurrentUser } from "@/utils";
import axios from "axios";
import { ref } from "vue";



export default function useUserLogin() {

    const user = ref([]);
    const errors = ref('');
    const loginUser = async (data) => {
    errors.value = ''

       try {
        let response = await axios.post('/api/login', data);


          const item = { token: response.data.data.access_token, ...response.data.data.user }
          user.value =item;
          setCurrentUser(item)
          store.commit('setUser', item)

        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {

                errors.value = e.response.data.errors;
            };



    };
};














    return {
        user,
        loginUser,


    }
}



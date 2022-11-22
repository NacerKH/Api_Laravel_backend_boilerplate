import store from "@/store";
import { setCurrentUser } from "@/utils";
import axios from "axios";
import { ref } from "vue";
import { useNotification } from "@kyvg/vue3-notification";

const notification = useNotification()


export default function useUserService() {

    const user = ref([]);
    const errors = ref('');
    const loginUser = async (data) => {
        errors.value = ''
        try {
            let response = await axios.post('/api/login', data);
            const item = { token: response.data.data.access_token, ...response.data.data.user }
            user.value = item;
            setCurrentUser(item)
            store.commit('setUser', item)

        } catch (e) {
                    console.log(e.response.data.message)
            if (e.response.status === 401) {
                setCurrentUser(null);
                store.commit('setError', e.response.data.message)
                setTimeout(() => {
                    store.commit('clearError')
                }, 3000)
                errors.value = e.response.data.message;
            };



        };
    };
    // const registerUser = async (data) => {
    //     errors.value = ''
    //  try {
    //     let response = await axios.post('/api/login', data);
    //     const item = { token: response.data.data.access_token, ...response.data.data.user }
    //       user.value =item;
    //       setCurrentUser(item)
    //       store.commit('setUser', item)

    //     } catch (e) {
    //         console.log(e);
    //         if (e.response.status === 422) {

    //             errors.value = e.response.data.errors;
    //         };
    // };
    // };
    const forgetPassword = async (email) => {
        errors.value = ''
        try {
            let response = await axios.post('/api/PasswordResetLink', email);
            store.commit('clearError')
            store.commit('setForgotMailSuccess')

        } catch (e) {

            store.commit('setError', e.response.data.message)
            setTimeout(() => {
                store.commit('clearError')
            }, 3000)
            if (e.response.status === 404) {

                errors.value = e.response.data.errors;
            };
        }
    }
    // }
    // const reset=async (data)=>{
    //     errors.value = ''
    //     try {
    //         let response = await axios.post('/api/ForgotPassword', data);

    //         } catch (e) {
    //             console.log(e);
    //             if (e.response.status === 404) {

    //                 errors.value = e.response.data.errors;
    //             };
    // }


    // const verficationEmail=async ()=>{

    // }

    const logOutUser=async ()=>{
        errors.value = ''
        try {


        let response = await axios.post('/api/logout');
          console.log(response);
        store.setCurrentUser(null);
        store.commit('setLogout')
    } catch (e) {
         store.commit('setError', e.response.data.message)
         setTimeout(() => {
            store.commit('clearError')
        }, 3000)
        if (e.response.status === 404) {

            errors.value = e.response.data.errors;
        };
    }
}










    return {
        user,
        loginUser,
        forgetPassword,
        logOutUser


    }

}



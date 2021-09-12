import axios from 'axios'

const instance = axios.create({
    baseURL: '/api/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
});

instance.CancelToken = axios.CancelToken;


export default instance

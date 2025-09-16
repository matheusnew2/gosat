import axios from 'axios';


const http = axios.create({
  baseURL: window.location.origin+'/api/v1',
  withCredentials:true,
  headers: {    
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

export default http;
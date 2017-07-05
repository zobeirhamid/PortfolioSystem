const Auth = () => {
    let auth = false;

    const loggedIn = () => {
      return auth;
    }

    const login = (token) => {
        auth = true;
        Object.assign(axios.defaults, {headers: {Authorization: 'Bearer '+ token}});
    }

    return {login, loggedIn};
}

export default Auth();


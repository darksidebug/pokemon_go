import SignIn from './components/SignIn';
import SignUp from './components/SignUp';
import Home from './components/Home';
import PageNoteFound from './components/PageNotFound';
import PokemonDetails from './components/PokemonDetails';
import MyProfile from './components/Profile';

export default{
    mode: 'history',
    routes:[
        {
            path: '*',
            component: PageNoteFound
        },
        {
            path: '/',
            component: SignIn
        },
        {
            path: '/sign-up',
            component: SignUp
        },
        {
            path: '/home',
            component: Home,
            beforeEnter: async (to, from, next) => {

                await axios.get('/api/authenticate')
                .then((res) => {

                    if(res.status === 200 && res.statusText === 'OK'){
                        next()
                    }
                })
                .catch(() => {
                    return next({path: '/'})
                })
            }
        },
        {
            path: '/pokemon/details/:id',
            component: PokemonDetails,
            beforeEnter: async (to, from, next) => {

                await axios.get('/api/authenticate')
                .then((res) => {

                    if(res.status === 200 && res.statusText === 'OK'){
                        next()
                    }
                })
                .catch(() => {
                    return next({path: '/'})
                })
            }
        },
        ,
        {
            path: '/my-profile',
            component: MyProfile,
            beforeEnter: async (to, from, next) => {

                await axios.get('/api/authenticate')
                .then((res) => {

                    if(res.status === 200 && res.statusText === 'OK'){
                        next()
                    }
                })
                .catch(() => {
                    return next({path: '/'})
                })
            }
        }
    ]
}
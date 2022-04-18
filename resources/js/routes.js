import SignIn from './components/SignIn';
import SignUp from './components/SignUp';
import Home from './components/Home';
import PageNoteFound from './components/PageNotFound';
import PokemonDetails from './components/PokemonDetails';
import MyProfile from './components/Profile';
import Collections from './components/Collections'

export default{
    mode: 'history',
    routes:[
        {
            path: '*',
            component: PageNoteFound
        },
        {
            path: '/',
            component: SignIn,
            beforeEnter: checkLoginToken
        },
        {
            path: '/sign-up',
            component: SignUp
        },
        {
            path: '/home',
            component: Home,
            beforeEnter: routeGuard
        },
        {
            path: '/pokemon/details/:id',
            component: PokemonDetails,
            beforeEnter: routeGuard
        },
        {
            path: '/my-profile',
            component: MyProfile,
            beforeEnter: routeGuard
        },
        {
            path: '/my-collections',
            component: Collections,
            beforeEnter: routeGuard
        }
    ]
}

function routeGuard(to, from, next){
    
    const token = localStorage.getItem('token')
    if(token === '' || token === undefined || token === null){

        return next({path: '/'})
    }else{

        next()
    }
}

function checkLoginToken(to, from, next){
    
    const token = localStorage.getItem('token')
    if(token !== '' || token !== undefined || token !== null){

        return next({path: '/home'})
    }
}


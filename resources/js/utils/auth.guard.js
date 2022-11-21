import { isAuthGuardActive } from '../constants/config'
import { setCurrentUser, getCurrentUser } from '.'
import { adminRoot } from '../constants/config'
import{UserRole} from './auth.roles'
export default (to, from, next) => {

  if (to.matched.some(record => record.meta.loginRequired)) {
    if (isAuthGuardActive) {
      const user = getCurrentUser();
      if (user) {
        const roleArrayHierarchic = to.matched.filter(x => x.meta.roles).map(x => x.meta.roles);

        if (roleArrayHierarchic.every(x => x.includes(user.role))) {
          next();
        } else {
          next('/unauthorized')
        }
      } else {
        setCurrentUser(null);
        next('/user/login')
      }

    } else {
      next();
    }
  }
  const user = getCurrentUser();

  if(to.matched.some(record => record.meta.hideForAuth)){
  if (user) {
   if(user.role==UserRole.Admin){
        next(adminRoot)
    }else if((user.role==UserRole.Editor)){
        next('/')
    }

  }else{
    next()

  }
}









  else {

    next()
  }
}


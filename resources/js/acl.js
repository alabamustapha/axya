export default class Acl{
  constructor(user, env) {
    this.user = user;
  }

  isSuperAdmin() 
  {
      return this.user.is_superadmin;
  }

  isAdmin() 
  {
      return this.user.is_admin;
  }

  isStaff() 
  {
      return this.user.is_staff;        
  }
}
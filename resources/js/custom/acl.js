export default class Acl{
  constructor(user) {
    this.user = user;
  }

  isLoggedIn() 
  {
      return typeof this.user != "undefined";
      // return typeof window.user != "undefined";
  }

  isSuperAdmin() 
  {
      return this.isLoggedIn() && this.user.is_superadmin;
  }

  isAdmin() 
  {
      return this.isLoggedIn() && this.user.is_admin;
  }

  isStaff() 
  {
      return this.isLoggedIn() && this.user.is_staff;        
  }
}
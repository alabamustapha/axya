<footer id="main-footer-override" class="main-footer bg-dark">
    <div class="container">
        <div class="container footer-copyright">

            {{-- <div class="d-block mx-auto"> --}}
            <ul class="list-unstyled mb-3 mx-auto">
                <li class="nav-item text-center mb-2">
                  <ul class="list-inline">
                      <li class="nav-item mb-2 list-inline-item">
                          <a class="nav-link" href="#">About</a>
                      </li>
                      <li class="nav-item mb-2 list-inline-item">
                          <a class="nav-link" href="#">FAQs</a>
                      </li>
                      <li class="nav-item mb-2 list-inline-item">
                          <a class="nav-link" href="#">Contact Us</a>
                      </li>
                  </ul>
                </li>
                {{-- 
                <li class="nav-item text-center mb-2">
                  <span>...</span>
                </li> --}}
            </ul>

            <div class="text-center">
                <span class="text-theme-blue">

                    <strong>{{config('app.name')}} &copy; {{ date('Y') }}</strong>
                  
                </span>
            </div>

        </div>
    </div>
</footer>
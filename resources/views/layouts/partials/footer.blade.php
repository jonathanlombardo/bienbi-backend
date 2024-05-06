{{-- <footer class="py-3 main_footer text-white">
  <div class="container d-flex justify-content-between">

    <nav>
      <span>Created by {{env("APP_AUTHOR", "Team 2 - Boolean #117")}}</span>
    </nav>
  </div>
</footer> --}}

<footer class="main_footer">
  <div class="container">
      <div class="row justify-content-between py-4">
          {{-- right --}}
          <div id="info-links" class="col-6">
              <ul class="d-flex gap-3 list-unstyled mb-0">
                  <li>
                      <a class="footer_link" href="#">&#169; 2024 Bien bi, Inc.</a>
                  </li>
                  <li>
                      <a class="footer_link" href="#">Privacy</a>
                  </li>
                  <li>
                      <a class="footer_link" href="#">Termini</a>
                  </li>
                  <li>
                      <a class="footer_link" href="#">FAQ</a>
                  </li>
              </ul>
          </div>
          {{-- left --}}
          <div id="socials-icons" class="col-6">
              <ul class="d-flex gap-3 list-unstyled mb-0 justify-content-end">
                  <li>
                      <a class="footer_link" href="#"><i class="fa-brands fa-square-facebook"></i></a>
                  </li>
                  <li>
                      <a class="footer_link" href="#"><i class="fa-brands fa-square-twitter"></i></a>
                  </li>
                  <li>
                      <a class="footer_link" href="#"><i class="fa-brands fa-square-instagram"></i></a>
                  </li>
              </ul>
          </div>
      </div>
  </div>
</footer>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>
  footer {
    background: #02133F;
    color: white;
    padding: 30px;
    text-align: left;
  }

  .footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }

  .footer-section {
    flex: 1;
    margin-right: 20px;
  }

  .footer-section h4 {
    font-weight: normal;
    margin-bottom: 10px;
  }

  .footer-section p {
    border: none;
    margin-bottom: -1px;
    font-size: 1.2rem;
  }

  .footer-logo {
    width: 120px;
    margin-bottom: 10px;
    position: relative;
    top: 10px;
    padding-right: 20px;
    margin-bottom: 18px;
  }

  .social-container {
    display: flex;
  }

  .social-container .social {
    margin: 0 10px;
  }

  .social i {
    color: #fff;
    font-size: 1.5rem;
  }

  .social i:hover {
    color: aqua;
  }

  .footer-social a {
    color: #fff;
    margin: 0 10px;
    font-size: 24px;
    text-decoration: none;
  }

  .footer-social a:hover {
    color: #aaa;
  }

  .footer-copyright {
    font-size: 20px;
    padding: 2px;
    margin-bottom: -30px;
 
  }

  .footer-copyright p {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

<footer>
  <div class="footer-container">
    <div class="footer-section">
      <p>Coder Store</p>
      <img src="{{ asset('/storage/web_image/coder.jpg') }}" alt="Coder Store Logo" class="footer-logo">
      <div class="social-container">
        <div class="social">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        </div>
        <div class="social">
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-section">
      <h4>Kebijakan</h4>
      <p><i> Syarat & ketentuan </i></p>
      <p><i> Kebijakan Privasi </i></p>
      <p><i> __ </i></p>
    </div>

    <div class="footer-section">
      <h4>Kontak Kami</h4>
      <p><i class="fa fa-envelope"></i> Kirim Pesan </p>
      <p><i class="fa fa-phone"></i> +62 813 1058 0000 </p>
      <p><i class="fa fa-map-marker"></i> Jl.Cibeureum Cikadu Kec.Cisayong</p>
    </div>
  </div>

  <div class="footer-copyright">
    <p>COPYRIGHT @BY MAGANG.PKL KOPI.CODER</p>
  </div>
  
</footer>
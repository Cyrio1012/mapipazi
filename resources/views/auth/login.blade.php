<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - APIPA Antananarivo</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="/assets/img/fav.png">

  <style>
    :root {
      --deep-blue: #1a5f7a;
      --ocean-blue: #2a7a9c;
      --aqua: #3aa6b9;
      --light-aqua: #57c4d4;
      --seafoam: #89d9d8;
      --water-surface: #c1ece4;
      --light-water: #e3f4f4;
      --white: #ffffff;
      --text-dark: #2c3e50;
      --text-light: #5a6c7d;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: url('/assets/img/back.webp') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* Effets d'eau en arrière-plan */
    .water-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .bubble {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      animation: float 15s infinite ease-in-out;
    }

    .bubble:nth-child(1) {
      width: 40px;
      height: 40px;
      left: 10%;
      animation-delay: 0s;
    }

    .bubble:nth-child(2) {
      width: 60px;
      height: 60px;
      left: 20%;
      animation-delay: 2s;
    }

    .bubble:nth-child(3) {
      width: 30px;
      height: 30px;
      left: 35%;
      animation-delay: 4s;
    }

    .bubble:nth-child(4) {
      width: 50px;
      height: 50px;
      left: 50%;
      animation-delay: 6s;
    }

    .bubble:nth-child(5) {
      width: 25px;
      height: 25px;
      left: 65%;
      animation-delay: 8s;
    }

    .bubble:nth-child(6) {
      width: 45px;
      height: 45px;
      left: 80%;
      animation-delay: 10s;
    }

    .bubble:nth-child(7) {
      width: 35px;
      height: 35px;
      left: 90%;
      animation-delay: 12s;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
        opacity: 0.7;
      }
      33% {
        transform: translateY(-30px) rotate(120deg);
        opacity: 0.4;
      }
      66% {
        transform: translateY(-60px) rotate(240deg);
        opacity: 0.6;
      }
    }

    .login-container {
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
      z-index: 1;
    }

    .login-card {
      background: var(--white);
      box-shadow: 0 15px 35px rgba(26, 95, 122, 0.15);
      overflow: hidden;
      display: flex;
      min-height: 600px;
      /*animation: fadeInUp 0.8s ease;*/
      position: relative;
    }

    @keyframes fadeInUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .brand-section {
      flex: 1;
      background: linear-gradient(135deg, var(--deep-blue), var(--aqua));
      color: white;
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .brand-section::before {
      content: '';
      position: absolute;
      width: 200px;
      height: 200px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      top: -100px;
      right: -100px;
    }

    .brand-section::after {
      content: '';
      position: absolute;
      width: 150px;
      height: 150px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      bottom: -75px;
      left: -75px;
    }

    .logo-container {
      margin-bottom: 2rem;
      z-index: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .logo-container img {
      max-width: 100%;
      max-height: 100%;
      width: auto;
      height: auto;
      filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
    }

    .form-section {
      /*flex: 1;*/
      padding: 3rem;
      /*display: flex;*/
      flex-direction: column;*/
      justify-content: space-between;
      background: var(--white);
      min-height: 600px;
      width: 500px;
      margin-top: auto;
      margin-bottom: auto;
      border-radius: 0px solid #eee !important;
    }

    .form-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-header {
      margin-bottom: 1rem;
      text-align: center;
    }

    .form-header h2 {
      color: var(--deep-blue);
      font-family: 'Quicksand', sans-serif;
      font-weight: 600;
    
    }

    .form-header p {
      color: var(--text-light);
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .input-group {
      position: relative;
    }

    .input-group .form-control {
      padding-left: 2.5rem;
      height: 50px;
      border-radius: 10px;
      border: 1px solid var(--water-surface);
      transition: all 0.3s;
      font-family: 'Arial narrow', sans-serif;
    }

    .input-group .form-control:focus {
      border-color: var(--aqua);
      box-shadow: 0 0 0 0.2rem rgba(58, 166, 185, 0.25);
    }

    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--aqua);
      z-index: 5;
    }

    .form-check {
      margin-bottom: 1.5rem;
    }

    .form-check-input:checked {
      background-color: var(--aqua);
      border-color: var(--aqua);
    }

    .form-check-label {
      color: var(--text-light);
      font-size: 0.8rem;
    }

    .btn-login {
      background: linear-gradient(135deg, var(--aqua), var(--deep-blue));
      border: none;
      color: white;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(58, 166, 185, 0.4);
      font-family: 'Quicksand', sans-serif;
    }

    .btn-login:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(58, 166, 185, 0.6);
    }

    .forgot-password {
      color: white;
      shadow: 0 2px 5px rgba(0,0,0,0.2);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .forgot-password:hover {
      color: var(--deep-blue);
    }

    .footer-links {
      text-align: center;
      color: var(--text-light);
      font-size: 0.9rem;
      margin-top: auto;
      
    }

    @media (max-width: 992px) {
      .login-card {
        flex-direction: column;
        min-height: auto;
      }
      
      .brand-section, .form-section {
        padding: 2rem;
      }
      
      .brand-section {
        min-height: 300px;
      }
      
      .form-section {
        min-height: auto;
      }
    }

    @media (max-width: 576px) {
      .brand-section, .form-section {
        padding: 1.5rem;
      }
      
      .brand-text h1 {
        font-size: 1.8rem;
      }
    }
    
    .brand-section img {
      animation: fadeInOut 2s infinite;
    }

    /* Animation fade */
    @keyframes fadeInOut {
      0%   { opacity: 1; }
      25%  { opacity: 0.75; }
      50%  { opacity: 0.5; }
      75%  { opacity: 0.75; }
      100% { opacity: 1; }
    }
    
    /* Ajustement pour que le formulaire prenne toute la hauteur disponible */
    .form-wrapper {
      display: flex;
      flex-direction: column;
      height: 100%;
      justify-content: space-between;

      padding: 10px;
    }
    .tete{
        color: var(--deep-blue);
        font-family: 'Quicksand', sans-serif;
        background-color: #1484ae;
        opacity: 0.6;
        padding: 20px;
        color: white;
    }
    h1{
        font-weight: 600;
        font:bold;
    }
    input::placeholder{
        font-size: 10px;
        color: #888;
        font-weight: 400;
        font-family: 'Arial narrow', sans-serif;
    }
    input[type="password"] {
  font-size: 10px; /* agrandit les puces */
}
  </style>
</head>
<body>


  <div class="login-container">
    
    <div class="login-card">
      
      <!-- Section de marque avec logo -->
      <div class="brand-section">
        <div class="logo-container">
          <img src="/assets/img/Apipa.webp" alt="Logo APIPA Antananarivo" class="img-fluid">
        </div>
      </div>

      <!-- Section du formulaire -->
      <div class="form-section">
        <div class="form-wrapper">
          <!-- Contenu du formulaire -->
          <div class="form-content">
            <div class="form-header">
                <h2 class="mt-2">Authentification</h2>
                <p class="mt-5">Entrez vos identifiants pour se connecter</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <!-- Email -->
              <div class="form-group">
                <div class="input-group">
                  <i class="fas fa-envelope input-icon"></i>
                  <input type="email" id="email" name="email" class="form-control" required autofocus autocomplete="username" value="{{ old('email') }}" placeholder="votre@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
              </div>

              <!-- Password -->
              <div class="form-group">
                <div class="input-group">
                  <i class="fas fa-lock input-icon"></i>
                  <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" placeholder="Votre mot de passe">
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
              </div>

              <!-- Remember Me -->
              <div class="d-flex  align-items-center justify-content-center form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
              </div>

              <!-- Actions -->
              <div class="d-flex  align-items-center justify-content-center  mb-3">
                <button type="submit" class=" btn btn-login">
                     Connexion
                </button>
              </div>
              

            </form>
          </div>

          
        </div>
      </div>
    </div>
       <div class="text-end">
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="forgot-password">
                    Mot de passe oublié ?
                  </a>
                @endif
              </div>
    <!-- Footer -->
    <div class="footer-links">
        <p>© APIPA, IVW 18E Anosizato Est II. Tous droits réservés.</p>
    </div>
 
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
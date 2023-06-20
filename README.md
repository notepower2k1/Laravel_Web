# Laravel e-document website
## 1. Project Detail
- FrontEnd: HTML, CSS, JS
- BackEnd: PHP
- Framework: Laravel 9
- Database: MySQL
- Storage: Firebasestorage
- Mail: Gmail API
- Real time Socket: Pusher API
- Captcha: recaptcha Google API
- Login using Gmail: Google API
- ChatBot: OpenAI API
- Demo: [Link to website](https://edocumentntu-app-3986t.ondigitalocean.app)
<img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/image_2023-06-20_214547095.png">

## 2. How to use 
### Note: You should download php ^8.0.2 or higher version, download laravel framework (version 9.x.x) and composer first
- First: Import [mysql](https://github.com/notepower2k1/Laravel_Web/tree/mysql) (I'm using xampp to demo).
- Second: Clone my project.
- Third: Using command *composer install* to download all package.
- Fourth: Config file
  - config *firebase-credentials.json* to use firebase storage
  - config .env
    - config database variable 
      - DB_CONNECTION=mysql
      - DB_HOST
      - DB_PORT
      - DB_DATABASE
      - DB_USERNAME
      - DB_PASSWORD
    - config firebasestorage variable
      - FIREBASE_CREDENTIALS
      - FIREBASE_DATABASE_URL
    - config mailer variable
      - MAIL_MAILER
      - MAIL_HOST
      - MAIL_PORT
      - MAIL_USERNAME
      - MAIL_PASSWORD
      - MAIL_ENCRYPTION
      - MAIL_FROM_ADDRESS
      - MAIL_FROM_NAME
    - config pusher variable to using pusher api. I used pusher to real time notify and comment
      - PUSHER_APP_ID
      - PUSHER_APP_KEY
      - PUSHER_APP_SECRET
      - PUSHER_HOST
      - PUSHER_PORT
      - PUSHER_SCHEME
      - PUSHER_APP_CLUSTER
    - config captcha variable.I used recaptcha google api
      - NOCAPTCHA_SECRET
      - NOCAPTCHA_SITEKEY
    - config openai api key
      - OPENAI_API_KEY
    - config google login api
      - GOOGLE_CLIENT_ID
      - GOOGLE_CLIENT_SECRET
      - GOOGLE_REDIRECT

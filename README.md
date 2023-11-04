# WordPress newsletter
<div>This is a plugin for WordPress sites that allows you to send newsletters to subscribers</div>
<br><br>
<div>
  <h2>Features</h2>
  <ul>
    <li>
      <h4>Frontend</h4>
      <ul>
        <li>Form in the footer of every page that allow users to request the newsletter signing up</li>
        <li>Email verification to validate the inserted email address</li>
        <li>Unsubscribe link inserted in every sended newsletter</li>
      </ul>
    </li>
    <li>
      <h4>Backend</h4>
      <ul>
        <li>Menu to set some newsletter options</li>
        <li>Admin panel to select the subscribers to whom the newsletter</li>
        <li>Log to show the sending status of the newsletters</li>
        <li>Admin panel to delete the selected subscribers from the newsletter contacts list</li>
        <li>Admin panel to add a new user skipping the email verification procedure</li>
      </ul>
    </li>
    <li>The backend features can also excuted with API requests, by providing the <a href="https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/">Wordpress Application Password</a> credentials</li>
  </ul>
  <br><br>
  <div>
    You need <a href="https://nodejs.org/en/download">NodeJs</a> and <a href="https://nodejs.org/en/download">Composer</a> to compile your sources.<br><br>
</div>
<div>
    Next run from your terminal:<br>
    <ul>
        <li><b>npm i</b></li>
        <li><b>composer install</b></li>
        <li><b>npm run dev</b></li>
    </ul>
    
</div>
<div>
    <br><br>
    If you want use this plugin in production:<br>
    <ul>
       <li><b>npm i --omit=dev</b></li>
       <li><b>composer install --optmize=autoloader --no-dev</b></li>
       <li><b>npm run build</b></li>
       <li>Create the .zip archive with this command: <b>zip -r assets classes config dist enums exceptions interfaces node_modules scripts traits vendor .env .htaccess newsletter.php</b></li>
       <li>Install the plugin uploading the created zip file</li>
    </ul>
</div>
  <br><br>
  <div><a href="https://user-images.githubusercontent.com/95185311/204027983-ec64b742-0e26-4a9f-b967-6e8227043832.mp4">Quick demo video</a></div>
  </div>
</div>

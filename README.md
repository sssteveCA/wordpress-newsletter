# WordPress newsletter
<div>This is a plugin for WordPress sites that allows you to send newsletters to subscribers</div>
<br>
<div>This plugin requires <a href="https://getbootstrap.com/docs/5.0/getting-started/download/">Bootstrap v5.2</a> to work properly. You can enqueue the needed files from the node_modules/bootstrap/dist directory, if they aren't already on your site.</div>
<br>
<div>To send the email it's used <a href="https://github.com/PHPMailer/PHPMailer">PHPMailer library</a> with SMTP authentication</div>
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
        <li>Admin panel to select the subscribers to whom the newsletter</li>
        <li>Admin panel to delete the selected subscribers from the newsletter contacts list</li>
        <li>Admin panel to add a new user skipping the email verification procedure</li>
      </ul>
    </li>
    <li>The backend features can also excuted with API requests, by providing the <a href="https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/">Wordpress Application Password</a> credentials</li>
  </ul>
  <br>
  <div><a href="https://user-images.githubusercontent.com/95185311/204027983-ec64b742-0e26-4a9f-b967-6e8227043832.mp4">Quick demo video</a></div>
  </div>
</div>

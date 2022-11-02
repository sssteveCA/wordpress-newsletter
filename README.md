# WordPress newsletter
<div>This is a plugin for WordPress sites that allows you to send newsletters to subscribers</div>
<br>
<div>It's recommended added to your site the<a href="https://getbootstrap.com/docs/5.0/getting-started/download/">Compiled CSS and JS Bootstrap code v5.0</a> to ensure that this plugin works properly</div>
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
        <li>**Admin panel to add a new user skipping the email verification procedure</li>
      </ul>
    </li>
    <li>*The backend features can also excuted with API requests, by providing the administrator credentials</li>
  </ul>
  <br>
  <div>*This features have not been added yet</div>
  <div>**The backend script for add user from admin panel has not been added yet</div>
  <br>
  <div>NOTE!: At the moment there aren't the Javascript files to execute the PHP scripts asynchronously from the browser. They can be called directly launching the PHP files in the scripts folder</div>
  </div>
</div>

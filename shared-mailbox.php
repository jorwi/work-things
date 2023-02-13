<?php require_once 'header.php'; ?>
  <h4>Mailbox permissions</h4>

  <div class="row">
    <div class="eight columns">
      <p>Simply enter the target mailbox and all those needing access to it (comma separated) to get the PowerShell commands.</p>

      <form action="#" name="commands" method="post">
        <textarea class="u-full-width" placeholder="shared1@org.org.uk,shared2@org.org.uk,shared3@org.org.uk etc." name="mailbox" required="required"><?=isset($_POST['mailbox']) ? trim(htmlspecialchars($_POST['mailbox'])) : ''; ?></textarea>
        <textarea class="u-full-width" placeholder="user1@org.org.uk,user2@org.org.uk,user3@org.org.uk etc." name="users" required="required"><?=isset($_POST['users']) ? trim(htmlspecialchars($_POST['users'])) : ''; ?></textarea>

        <input class="button-primary" type="submit" value="Submit" name="show-commands">
      </form>
    </div>
  </div>
  
<?php
if (isset($_POST['show-commands'])) {
  $mailboxarray = trim(str_replace(', ' , ',', htmlspecialchars($_POST['mailbox'])));
  $userarray = trim(str_replace(', ' , ',', htmlspecialchars($_POST['users'])));

  $mailboxes = explode((','), $mailboxarray);
  $users = explode((','), $userarray);
?>
  <h6>Here are the commands for the requested mailbox(es):</h6>

  <div>
    <strong>Connect to Microsoft:</strong><br>

    $LiveCred = Get-Credential<br>
    Connect-MSOLservice –Credential $livecred<br>
    $Session = New-PSSession -ConfigurationName Microsoft.Exchange -ConnectionUri https://ps.outlook.com/powershell/ -Credential $LiveCred -Authentication Basic -AllowRedirection<br>
    Import-PSSession $Session<br><br>
    If you have upgraded the Exchange PowerShell module run this:<br><br>Connect-ExchangeOnline<!-- -UserPrincipalName <em>you</em>@org.org.uk-->
  </div>

  <hr>

<?php
  foreach ($mailboxes AS $mailbox) {
    foreach ($users AS $user) {
   
?>
  <p>
    Add-MailboxPermission -Identity "<?=$mailbox?>" -User "<?=$user?>" -AccessRights FullAccess -AutoMapping:$false<br>
    Add-RecipientPermission "<?=$mailbox?>" -Trustee "<?=$user?>" -AccessRights SendAs
  </p>

<?php
    }
  }
}
?>
</div>

</body>
</html>

<h1>Record Sale</h1>
<?php
$attr = array(
    'name'          => 'frm',
    'id'            => 'frm',
    'autocomplete'  => 'off',
);
$action = base_url().'record-sale';
echo form_open($action, $attr);
?>
    <label for="user_id">User </label>
        <select name="user_id" id="user_id">
            <option value="0">-Select-</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
            <?php endforeach; ?>
        </select>
    <br>
    <label for="amount">Amount:</label>
    <input type="number" step="0.01" name="amount" id="amount" required>
    <br>
    <button type="button" onclick="validate()" >Record Sale</button>
<?php echo form_close(); ?>

<script>
function validate(){
    if(document.getElementById('user_id').value ==0){
        alert('Please select the user');
        return false;
    }
    if(document.getElementById('amount').value==''){
        alert('Please enter the amount');
        return false;
    }
    if(document.getElementById('amount').value==0){
        alert('Please enter a valid amount');
        return false;
    }
    document.frm.submit();
}
</script>
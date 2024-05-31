
<h1>Add Affiliation</h1>

<?php
$attr = array(
    'name'          => 'frm',
    'id'            => 'frm',
    'autocomplete'  => 'off',
);
$action = base_url().'add-hierarchy';
echo form_open($action, $attr);
?>
<label for="user_id">Select User:</label>
<select name="user_id" id="user_id">
    <option value="0">-Select-</option>
    <?php foreach ($users as $user): ?>
        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
    <?php endforeach; ?>
</select>
<br><br>

<label for="parent_id">Select Parent:</label>
<select name="parent_id" id="parent_id">
    <option value="0">-Select-</option>
    <?php foreach ($parent as $user): ?>
        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
    <?php endforeach; ?>
</select>
<br><br>

<input type="button" onclick="validate()" value="Add Affiliation">

<?php echo form_close(); ?>

<script>

function validate(){
    if(document.getElementById('user_id').value ==0){
        alert('Please select the user');
        return false;
    }
    if(document.getElementById('user_id').value == document.getElementById('parent_id').value){
        alert('User and Parent must not be same.');
        return false;
    }
    document.frm.submit();
}
</script>

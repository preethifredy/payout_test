
<h1>Payouts details</h1>
<table border="1">
    <thead>
        <tr>
            <th>Affiliate Name</th>
            <th>Amount</th>
            <th>Level</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payouts as $payout): ?>
            <tr>
                <td><?php echo $payout['AffiliateName']; ?></td>
                <td><?php echo $payout['amount']; ?></td>
                <td><?php echo $payout['level']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

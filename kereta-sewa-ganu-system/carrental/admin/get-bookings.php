<?php
include('includes/config.php');

if (isset($_POST['month'])) {
    $selectedMonth = $_POST['month'];
    $status = 1; // Assuming you want to fetch confirmed bookings only
    $sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber, tblpayment.amount
    FROM tblpayment 
    JOIN tblbooking ON tblpayment.bookingid=tblbooking.id 
    JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId 
    JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail 
    JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id   
    WHERE tblbooking.Status=:status AND MONTH(tblbooking.ToDate) = :selectedMonth";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':selectedMonth', $selectedMonth, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        $cnt = 1;
        $totalSum = 0; // Variable to store the total sum
        foreach ($results as $result) {
            echo '<tr>';
            echo '<td>' . htmlentities($cnt) . '</td>';
            echo '<td>' . htmlentities($result->FullName) . '</td>';
            echo '<td>' . htmlentities($result->BookingNumber) . '</td>';
            echo '<td><a href="edit-vehicle.php?id=' . htmlentities($result->vid) . '">' . htmlentities($result->BrandName) . ' , ' . htmlentities($result->VehiclesTitle) . '</td>';
            echo '<td>' . htmlentities($result->ToDate) . '</td>';
            
            echo '<td>';
            if ($result->Status == 0) {
                echo htmlentities('Not Confirmed yet');
            } else if ($result->Status == 1) {
                echo htmlentities('Confirmed');
            } else {
                echo htmlentities('Cancelled');
            }
            echo '</td>';
            echo '<td>' . htmlentities($result->amount) . '</td>';
            echo '</tr>';
            $cnt++;

            // Calculate the total sum
            $totalSum += $result->amount;
        }

        // Display the total sum row
        echo '<tr>';
        echo '<td colspan="6" style="text-align:right;"><strong>Total:</strong></td>';
        echo '<td><strong>' . htmlentities($totalSum) . '</strong></td>';
        echo '</tr>';
    } else {
        echo '<tr><td colspan="7" style="text-align:center;">No bookings found for the selected month.</td></tr>';
    }
}
?>

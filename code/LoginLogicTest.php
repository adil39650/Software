<?php
require_once 'Login.php';

use PHPUnit\Framework\TestCase;

class LoginLogicTest extends TestCase {
    public function testSuccessfulLoginRedirect() {
        // Mock database connection
        global $con;
        $con = $this->createMock(mysqli::class);
        
        // Mock database result
        $mockRes = $this->createMock(mysqli_result::class);
        $mockRes->method('num_rows')->willReturn(1);
        $mockRes->method('fetch_assoc')->willReturn(['role' => 1, 'id' => 1]);

        // Mock database query
        $con->method('query')->willReturn($mockRes);

        // Mock session
        $_SESSION = [];

        // Set $_POST data
        $_POST['username'] = 'admin';
        $_POST['password'] = 'adminpass';
        $_POST['submit'] = true;

        // Call login function
        loginUser('admin', 'adminpass');

        // Check session variables
        $this->assertEquals('yes', $_SESSION['IS_LOGIN']);
        $this->assertEquals('admin', $_SESSION['USERNAME']);
        $this->assertEquals(1, $_SESSION['ROLE']);
        $this->assertEquals(1, $_SESSION['USER_ID']);
    }

    // Add more tests as needed
}
?>

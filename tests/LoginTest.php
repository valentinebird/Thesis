<?php


use PHPUnit\Framework\TestCase;

function authenticateUser($username, $password, $mysqli) {
    if ($stmt = $mysqli->prepare('SELECT id, password FROM USER WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                return ['loggedin' => TRUE, 'id' => $id];
            } else {
                return ['loggedin' => FALSE, 'error' => 'Incorrect password'];
            }
        } else {
            return ['loggedin' => FALSE, 'error' => 'Username not found'];
        }
    } else {
        return ['loggedin' => FALSE, 'error' => 'Database query error'];
    }
}

class LoginTest extends TestCase {
    private $mysqliMock;

    protected function setUp(): void {
        $this->mysqliMock = $this->createMock(mysqli::class);
    }

    public function testSuccessfulLogin() {
        $username = 'testuser';
        $password = 'correctpassword';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('num_rows')->willReturn(1);
        $stmtMock->method('bind_result')->willReturnCallback(function() use ($username, &$hashedPassword) {
            $hashedPassword = password_hash('correctpassword', PASSWORD_DEFAULT);
        });
        $stmtMock->method('fetch')->willReturn(TRUE);

        $this->mysqliMock->method('prepare')->willReturn($stmtMock);

        $result = authenticateUser($username, $password, $this->mysqliMock);
        $this->assertTrue($result['loggedin']);
    }


}

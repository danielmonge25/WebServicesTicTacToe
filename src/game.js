document.addEventListener("DOMContentLoaded", function () {
    let currentTurn = "X";
    let winner = false;
    let serverUrl = "https://titanic.ecci.ucr.ac.cr/~eb85017/ServicioWeb/server.php";

    let cells = document.getElementsByClassName("cell");
    let resetButton = document.getElementById("resetButton");
    let message = document.getElementById("message");
    let info = document.getElementById("info");

    function restartGame() {
        let request = {
            jsonrpc: "2.0",
            method: "restartGame",
            params: [],
            id: 1,
        };
        fetch(serverUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(request),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.error) {
                    console.log("Error:", data.error);
                } else if (data.info) {
                    console.log("Info:", data.info);
                } else {
                    updateGameState(data.board, data.turn, data.winner, data.tie);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });


        for (let i = 0; i < cells.length; i++) {
            cells[i].firstElementChild.classList.remove("X", "O");
            cells[i].addEventListener("click", makeUserMove);
        }
        message.textContent = "";
        info.textContent = "";
        currentTurn = "X";
        winner = false;
    }

    function makeUserMove() {
        if (currentTurn === 'X' && winner === false) {
            let row = this.parentNode.rowIndex;
            let column = this.cellIndex;

            let params = [row, column];
            let request = {
                jsonrpc: "2.0",
                method: "makeMove",
                params: params,
                id: 1,
            };

            fetch(serverUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(request),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.error) {
                        console.log("Error:", data.error);
                    } else if (data.info) {
                        console.log("Info:", data.info);
                        info.textContent = `${data.info}`;
                    } else {
                        updateGameState(data.board, data.turn, data.winner, data.tie);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });

        } else {
            console.log('There is already a winner or it is not your turn.')
        }

    }

    function updateGameState(board, turn, winner, tie) {
        for (let row = 0; row < board.length; row++) {
            for (let column = 0; column < board[row].length; column++) {
                let element = board[row][column];
                let cell = cells[row * 3 + column];
                if (element === 'X' || element === 'O') {
                    cell.firstElementChild.classList.add(element);
                }
            }
        }

        if (winner) {
            showAlert(`Player ${winner} has won!`, 'success');
        } else if (tie) {
            showAlert("It's a tie!", 'info');
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.classList.add('alert', `alert-${type}`);
            alertDiv.textContent = message;

            const container = document.getElementById('container');
            container.insertBefore(alertDiv, container.firstChild);

            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    }    
    resetButton.addEventListener("click", restartGame);
    restartGame();
});

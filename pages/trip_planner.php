<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Planner | Travella</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 60%;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .date-input {
            display: flex;
            gap: 10px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #ff7e5f;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #e06c53;
        }

        #friend_list div {
            display: flex;
            justify-content: space-between;
            padding: 5px;
            background: #f1f1f1;
            margin-top: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Plan a New Trip</h2>
        <form action="save_trip.php" method="POST">
            <label for="destination">Where to?</label>
            <input type="text" id="destination" name="destination" placeholder="E.g. Paris, London, Maldives" required>

            <label>Start & End Date</label>
            <div class="date-input">
                <input type="text" id="start_date" name="start_date" placeholder="Start Date" required>
                <input type="text" id="end_date" name="end_date" placeholder="End Date" required>
            </div>

            <label for="search_friends">Invite Friends</label>
            <input type="text" id="search_friends" placeholder="Search your connections">
            <div id="friend_list"></div>
            <input type="hidden" id="selected_friends" name="selected_friends">

            <label for="description">Describe Your Trip</label>
            <textarea id="description" name="description" placeholder="Enter a description of the plan" rows="3"></textarea>

            <label for="trip_type">Type of Trip</label>
            <select id="trip_type" name="trip_type">
                <option value="art">Art and Culture</option>
                <option value="sport">Sport</option>
                <option value="nature">Nature</option>
                <option value="road">On the Road</option>
                <option value="dance">Dance & Fun</option>
                <option value="relax">Relax</option>
                <option value="backpacking">Backpacking</option>
                <option value="pilgrimage">Pilgrimage</option>
            </select>

            <div class="button-container">
                <button type="button">Back</button>
                <button type="submit">Start Planning</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#start_date");
        flatpickr("#end_date");

        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search_friends");
            const friendList = document.getElementById("friend_list");
            const selectedFriendsInput = document.getElementById("selected_friends");
            let selectedFriends = [];

            searchInput.addEventListener("input", function () {
                fetch("fetch_friends.php")
                    .then(response => response.json())
                    .then(friends => {
                        friendList.innerHTML = "";
                        const filteredFriends = friends.filter(f => f.username.toLowerCase().includes(searchInput.value.toLowerCase()));

                        filteredFriends.forEach(friend => {
                            const friendItem = document.createElement("div");
                            friendItem.innerHTML = `${friend.username} <button onclick="addFriend('${friend.id}', '${friend.username}')">+</button>`;
                            friendList.appendChild(friendItem);
                        });
                    });
            });

            window.addFriend = function (id, name) {
                if (!selectedFriends.some(f => f.id === id)) {
                    selectedFriends.push({ id, name });
                    updateSelectedFriends();
                }
            };

            function updateSelectedFriends() {
                friendList.innerHTML = "";
                selectedFriends.forEach(friend => {
                    const friendItem = document.createElement("div");
                    friendItem.innerHTML = `${friend.name} <button onclick="removeFriend('${friend.id}')">❌</button>`;
                    friendList.appendChild(friendItem);
                });
                selectedFriendsInput.value = JSON.stringify(selectedFriends);
            }

            window.removeFriend = function (id) {
                selectedFriends = selectedFriends.filter(f => f.id !== id);
                updateSelectedFriends();
            };
        });
    </script>
</body>
</html>
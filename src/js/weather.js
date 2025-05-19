// Get DOM elements
const weatherForm = document.getElementById("weatherForm");
const cityInput = document.getElementById("cityInput");
const card = document.getElementById("card");
const apiKey = "e6c65b8d5608f3c50a772043bef0e216";

weatherForm.addEventListener("submit", async event => {
    event.preventDefault(); // Prevent form from reloading the page
    const city = cityInput.value;
    if (city) {
        try {
            const data = await getWeatherData(city); // Fetch weather info
            displayWeatherInfo(data);
        } catch (error) {
            displayError(error.message); // Show fetch error
        }
    }
    else {
        displayError("Please enter a city"); // Handle empty input
    }

});

async function getWeatherData(city) {
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=imperial
`;
    
    const response = await fetch(apiUrl);

    if(!response.ok){
        throw new Error("Could not fetch weather data");
    }

    return await response.json(); // Convert response to JSON
}

function displayWeatherInfo(data) {
     // Destructure the response data
    const {name: city, main:{temp, humidity}, weather: [{description, id}]} = data;

     // Clear existing results
     card.textContent = "";

     // Create elements
     const cityDisplay = document.createElement("h1");
     cityDisplay.textContent = city;
     cityDisplay.className = "text-3xl font-bold";
 
     const tempDisplay = document.createElement("p");
     tempDisplay.textContent = `${temp}°F`;
     tempDisplay.className = "text-xl";
 
     const humidityDisplay = document.createElement("p");
     humidityDisplay.textContent = `Humidity: ${humidity}%`;
     humidityDisplay.className = "text-lg";
 
     const descDisplay = document.createElement("p");
     descDisplay.textContent = description;
     descDisplay.className = "capitalize text-gray-600";
 
     const emojiDisplay = document.createElement("p");
     emojiDisplay.textContent = getWeatherEmoji(id);
     emojiDisplay.className = "text-9xl";
 
     // Append elements to the card
     card.appendChild(cityDisplay);
     card.appendChild(tempDisplay);
     card.appendChild(humidityDisplay);
     card.appendChild(descDisplay);
     card.appendChild(emojiDisplay);
}

function getWeatherEmoji(weatherId) {
    if (weatherId >= 200 && weatherId < 300) return "⛈️";
    if (weatherId >= 300 && weatherId < 500) return "🌦️";
    if (weatherId >= 500 && weatherId < 600) return "🌧️";
    if (weatherId >= 600 && weatherId < 700) return "❄️";
    if (weatherId >= 700 && weatherId < 800) return "🌫️";
    if (weatherId === 800) return "☀️";
    if (weatherId > 800) return "☁️";
    return "❓";
}

function displayError(message) {
    const errorDisplay = document.createElement("p");
    errorDisplay.textContent = message;

    card.textContent = " ";
    card.appendChild(errorDisplay);
}
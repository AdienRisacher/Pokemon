

const timers = document.getElementsByClassName("timer");

for (let i = 0; i < timers.length; i++) {
  setInterval(() => {
    let time = timers[i].innerText.split(":");
    let minutes = parseInt(time[0]);
    let secondes = parseInt(time[1]);
    secondes--;
    if (secondes < 0) {
      secondes = 59;
      minutes--;
    }
    if (minutes < 0) {
      document.location.reload();
    }
    minutes = minutes < 10 ? "0" + minutes : minutes
    secondes = secondes < 10 ? "0" + secondes : secondes

    timers[i].innerText = `${minutes}:${secondes}`
    temps = temps <= 0 ? 0 : temps - 1
  }, 1000)
}



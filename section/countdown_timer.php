
  <div class="container_counter">

    <div class="container-segment">
      <div class="segment-title">Jours</div>
      <div class="segment">
        <div class="flip-card" data-days-hundreds>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
        <div class="flip-card" data-days-tens>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
        <div class="flip-card" data-days-ones>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
      </div>
    </div>
    <div class="container-segment">
      <div class="segment-title">Heures</div>
      <div class="segment">
        <div class="flip-card" data-hours-tens>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
        <div class="flip-card" data-hours-ones>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
      </div>
    </div>
    <div class="container-segment">
      <div class="segment-title">Minutes</div>
      <div class="segment">
        <div class="flip-card" data-minutes-tens>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
        <div class="flip-card" data-minutes-ones>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
      </div>
    </div>
    <div class="container-segment">
      <div class="segment-title">Secondes</div>
      <div class="segment">
        <div class="flip-card" data-seconds-tens>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
        <div class="flip-card" data-seconds-ones>
          <div class="top">0</div>
          <div class="bottom">0</div>
        </div>
      </div>
    </div>
  </div>


<script>
const countToDate = "<?php echo $config['event_date_start'] ?>";
const targetDateInSeconds = Math.ceil(Date.parse(countToDate) / 1000);

let previousTimeBetweenDates;
let intervalId = setInterval(() => {
  const currentDateInSeconds = Math.ceil(new Date().getTime() / 1000);
  const timeBetweenDates = targetDateInSeconds - currentDateInSeconds;

  if (timeBetweenDates <= 0) {
    clearInterval(intervalId); // Arrêter l'intervalle
    setAllCardsToZero(); // Mettre toutes les cartes à zéro
    return; // Arrêter l'exécution de la fonction
  }

  flipAllCards(timeBetweenDates);
  previousTimeBetweenDates = timeBetweenDates;
}, 250);

function setAllCardsToZero() {
  const zeroCards = document.querySelectorAll('[data-days-tens], [data-days-ones], [data-hours-tens], [data-hours-ones], [data-minutes-tens], [data-minutes-ones], [data-seconds-tens], [data-seconds-ones]');
  zeroCards.forEach(card => {
    flip(card, 0);
  });
}

function flipAllCards(time) {
  const days = Math.floor(time / (24 * 3600));
  const hours = Math.floor((time % (24 * 3600)) / 3600);
  const minutes = Math.floor((time % 3600) / 60);
  const seconds = time % 60;

  const daysHundreds = document.querySelector("[data-days-hundreds]");
  if (days >= 100) {
    flip(daysHundreds, Math.floor(days / 100));
    daysHundreds.classList.remove('hide');
  } else {
    daysHundreds.classList.add('hide');
  }

  flip(document.querySelector("[data-days-tens]"), Math.floor((days % 100) / 10));
  flip(document.querySelector("[data-days-ones]"), days % 10);
  flip(document.querySelector("[data-hours-tens]"), Math.floor(hours / 10));
  flip(document.querySelector("[data-hours-ones]"), hours % 10);
  flip(document.querySelector("[data-minutes-tens]"), Math.floor(minutes / 10));
  flip(document.querySelector("[data-minutes-ones]"), minutes % 10);
  flip(document.querySelector("[data-seconds-tens]"), Math.floor(seconds / 10));
  flip(document.querySelector("[data-seconds-ones]"), seconds % 10);
}


function flip(flipCard, newNumber) {
  const topHalf = flipCard.querySelector(".top");
  const startNumber = parseInt(topHalf.textContent);
  if (newNumber === startNumber) return;

  const bottomHalf = flipCard.querySelector(".bottom");
  const topFlip = document.createElement("div");
  topFlip.classList.add("top-flip");
  const bottomFlip = document.createElement("div");
  bottomFlip.classList.add("bottom-flip");

  topHalf.textContent = startNumber;
  bottomHalf.textContent = startNumber;
  topFlip.textContent = startNumber;
  bottomFlip.textContent = newNumber;

  topFlip.addEventListener("animationstart", e => {
    topHalf.textContent = newNumber;
  });
  topFlip.addEventListener("animationend", e => {
    topFlip.remove();
  });
  bottomFlip.addEventListener("animationend", e => {
    bottomHalf.textContent = newNumber;
    bottomFlip.remove();
  });
  flipCard.append(topFlip, bottomFlip);
}
</script>

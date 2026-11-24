const intro = document.getElementById('intro');
const music = document.getElementById('bgMusic');

function openCurtain(){
  intro.classList.add('open');
  confettiBlast();
  setTimeout(()=>{
    intro.style.display='none';
    music.play();
  },1800);
}

function toggleMusic(){
  music.paused ? music.play() : music.pause();
}

/* Countdown */
const weddingDate = new Date("Dec 12, 2026 17:00:00").getTime();
setInterval(()=>{
  let now = new Date().getTime();
  let d = weddingDate - now;

  let days = Math.floor(d / (1000*60*60*24));
  let hours = Math.floor((d%(1000*60*60*24))/(1000*60*60));
  let mins = Math.floor((d%(1000*60*60))/(1000*60));
  let secs = Math.floor((d%(1000*60))/1000);

  document.getElementById('countdown').innerHTML =
  `${days}d ${hours}h ${mins}m ${secs}s`;
},1000);

/* Fade on Scroll */
const fades=document.querySelectorAll('.fade');
window.addEventListener('scroll',()=>{
  fades.forEach(f=>{
    if(f.getBoundingClientRect().top < window.innerHeight - 80){
      f.classList.add('show');
    }
  });
});

/* WhatsApp */
function sendWhatsApp(e){
  e.preventDefault();
  let name=document.getElementById('name').value;
  let guests=document.getElementById('guests').value;
  let msg = `Wedding RSVP\nName: ${name}\nGuests: ${guests}`;
  window.open(`https://wa.me/91XXXXXXXXXX?text=${encodeURIComponent(msg)}`);
}

/* Photo Preview */
function previewPhoto(e){
  let img=document.getElementById('preview');
  img.src=URL.createObjectURL(e.target.files[0]);
  img.style.display='block';
}

/* QR Code */
document.getElementById('qrCode').src=
`https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(location.href)}`;

/* Rose Petals */
for(let i=0;i<35;i++){
  let p=document.createElement('span');
  p.style.left=Math.random()*100+'vw';
  p.style.animationDuration=(5+Math.random()*5)+'s';
  document.querySelector('.petals').appendChild(p);
}

/* Confetti */
const canvas = document.getElementById("confetti");
const ctx = canvas.getContext("2d");
canvas.width=window.innerWidth;
canvas.height=window.innerHeight;
let conf=[];

function confettiBlast(){
  for(let i=0;i<200;i++){
    conf.push({
      x:Math.random()*canvas.width,
      y:Math.random()*canvas.height,
      r:Math.random()*6+4,
      d:Math.random()*30,
      c:`hsl(${Math.random()*360},100%,60%)`
    });
  }
  animateConfetti();
}

function animateConfetti(){
  ctx.clearRect(0,0,canvas.width,canvas.height);
  conf.forEach(p=>{
    ctx.beginPath();
    ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
    ctx.fillStyle=p.c;
    ctx.fill();
    p.y+=3;
  });
  requestAnimationFrame(animateConfetti);
}
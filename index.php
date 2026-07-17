<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Culto Connect</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#212974',
          dark: '#12153f',
          light: '#37409e',
        },
        orange: {
          DEFAULT: '#ff751f',
          light: '#ffa25c',
        },
        cream: '#fff7f1',
        ink: '#14163a',
        whatsapp: {
          DEFAULT: '#25D366',
          dark: '#128C7E',
        },
        address: {
          DEFAULT: '#e53e3e',
          dark: '#c53030',
        },
      },
      fontFamily: {
        display: ['"Bricolage Grotesque"', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      },
    }
  }
}
</script>

<style>
  html{scroll-behavior:smooth;}
  body{font-family:'Inter', sans-serif; color:#14163a;}
  ::selection{background:#ff751f; color:#ffffff;}

 
  #thread-svg{
    position:fixed;
    left:28px;
    top:0;
    height:100vh;
    width:14px;
    z-index:40;
    pointer-events:none;
  }
  #thread-svg line{stroke:rgba(33,41,116,0.14); stroke-width:2;}
  #thread-svg .fill-line{stroke:#ff751f; stroke-width:2;}
  .thread-node{
    fill:#ffffff;
    stroke:#212974;
    stroke-width:2;
    transition:fill .4s ease, stroke .4s ease, r .4s ease;
  }
  .thread-node.active{fill:#ff751f; stroke:#ff751f; r:6;}
  @media (max-width: 991.98px){ #thread-svg{display:none;} }


  #network-canvas{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    opacity:.65;
  }

  .schedule-card{ transition:background-color .25s, color .25s; }
  .schedule-card:hover{ background:#212974; }
  .schedule-card:hover .s-day,
  .schedule-card:hover .s-desc{ color:rgba(255,255,255,0.7); }
  .schedule-card:hover .s-time{ color:#ffa25c; }

  
  .reveal{opacity:0; transform:translateY(24px); transition:opacity .7s ease, transform .7s ease;}
  .reveal.in{opacity:1; transform:translateY(0);}
  @media (prefers-reduced-motion: reduce){ html{scroll-behavior:auto;} }
</style>
</head>
<body class="bg-white">

<svg id="thread-svg"></svg>


<header class="fixed top-0 inset-x-0 z-50 bg-navy-dark/70 backdrop-blur-lg border-b border-white/10">
  <nav class="max-w-6xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
    <a href="#hero" class="font-display font-extrabold text-xl text-white tracking-tight">
     CULTO<span class="text-orange">CONNECT</span>
    </a>

    <ul class="hidden lg:flex items-center gap-9">
      <li><a href="#hero" class="text-white/80 hover:text-white text-sm font-medium transition">Início</a></li>
      <li><a href="#horarios" class="text-white/80 hover:text-white text-sm font-medium transition">Horários</a></li>
      <li><a href="#sobre" class="text-white/80 hover:text-white text-sm font-medium transition">Sobre</a></li>
      <li><a href="#aovivo" class="text-white/80 hover:text-white text-sm font-medium transition">Ao vivo</a></li>
      <li><a href="#local" class="text-white/80 hover:text-white text-sm font-medium transition">Local</a></li>
    </ul>

    <a href="#aovivo" class="hidden lg:inline-flex items-center rounded-full bg-orange text-white font-semibold text-sm px-5 py-2.5 shadow-lg shadow-orange/30 hover:-translate-y-0.5 hover:shadow-xl transition">
      Assista ao vivo
    </a>

  
    <button id="menuBtn" class="lg:hidden text-white" aria-label="Abrir menu">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
    </button>
  </nav>

  
  <div id="mobileMenu" class="hidden lg:hidden bg-navy-dark border-t border-white/10 px-6 py-5 flex flex-col gap-4">
    <a href="#hero" class="text-white/80 text-sm font-medium">Início</a>
    <a href="#horarios" class="text-white/80 text-sm font-medium">Horários</a>
    <a href="#sobre" class="text-white/80 text-sm font-medium">Sobre</a>
    <a href="#aovivo" class="text-white/80 text-sm font-medium">Ao vivo</a>
    <a href="#local" class="text-white/80 text-sm font-medium">Local</a>
    <a href="#aovivo" class="inline-flex justify-center rounded-full bg-orange text-white font-semibold text-sm px-5 py-2.5 mt-2">Assista ao vivo</a>
  </div>
</header>


<section id="hero" data-node="Início" class="relative min-h-screen flex items-center pt-28 overflow-hidden bg-[radial-gradient(120%_100%_at_15%_0%,_#37409e_0%,_#212974_45%,_#12153f_100%)]">
  <canvas id="network-canvas"></canvas>

  <div class="relative z-10 max-w-6xl mx-auto px-6 lg:px-8 w-full">
    <div class="max-w-3xl">
      <div class="inline-flex items-center gap-2.5 text-orange-light text-[13px] font-semibold uppercase tracking-widest mb-6">
        <span class="w-2 h-2 rounded-full bg-orange shadow-[0_0_0_4px_rgba(255,117,31,0.25)]"></span>
        Comunidade · Fé · Conexão
      </div>

      <h1 class="font-display font-bold text-white leading-[0.95] text-[44px] sm:text-6xl lg:text-8xl">
        FÉ QUE<br>SE <span class="text-orange">CONECTA</span>.
      </h1>

      <p class="mt-7 max-w-lg text-lg text-white/70 leading-relaxed">
        O Culto Connect existe pra ligar pessoas a Deus e umas às outras — presencial ou de onde você estiver. Um lugar pra chegar como você é.
      </p>

      <div class="mt-10 flex flex-wrap gap-4">
        <a href="#horarios" class="inline-flex items-center gap-2 rounded-full bg-orange text-white font-semibold px-7 py-4 shadow-lg shadow-orange/30 hover:-translate-y-0.5 transition">
          Ver horários dos cultos →
        </a>
        <a href="#aovivo" class="inline-flex items-center gap-2 rounded-full border border-white/30 text-white font-semibold px-7 py-4 hover:bg-white/10 transition">
          Assistir ao vivo
        </a>
      </div>
      
      </div>
    </div>
  </div>
</section>


<section id="horarios" data-node="Horários" class="py-28 bg-cream">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="reveal max-w-xl mb-16">
      <span class="block text-orange text-[13px] font-bold uppercase tracking-widest mb-3">Horários</span>
      <h2 class="font-display font-bold text-navy text-3xl sm:text-4xl lg:text-5xl leading-tight">
        Escolha o culto que combina com sua semana.
      </h2>
      <p class="mt-4 text-[#54588a] text-lg leading-relaxed">
        Presencial no templo ou ao vivo pelo youtube — a conexão é a mesma.
      </p>
    </div>

<div class="reveal grid md:grid-cols-4 border border-navy/10 rounded-2xl overflow-hidden divide-x divide-navy/10">
      <div class="schedule-card bg-white p-9">
        <div class="s-day text-[13px] font-bold uppercase tracking-wider text-navy-light">Quarta · Noite</div>
        <div class="s-time font-display text-4xl font-bold text-navy my-3">19h30</div>
        <div class="s-desc text-[#6a6e9c] text-sm leading-relaxed">PG dos Adolescentes, encontro marcado toda quarta-feira do mês.</div>
      </div>
      <div class="schedule-card bg-white p-9">
        <div class="s-day text-[13px] font-bold uppercase tracking-wider text-navy-light">Sexta · Noite</div>
        <div class="s-time font-display text-4xl font-bold text-navy my-3">19h30</div>
        <div class="s-desc text-[#6a6e9c] text-sm leading-relaxed">PG dos Adolescentes, encontro marcado toda sexta-feira do mês</div>
      </div>
      <div class="schedule-card bg-white p-9">
        <div class="s-day text-[13px] font-bold uppercase tracking-wider text-navy-light">Domingo . Manhã</div>
        <div class="s-time font-display text-4xl font-bold text-navy my-3">08h30</div>
        <div class="s-desc text-[#6a6e9c] text-sm leading-relaxed">Culto Connect, acontece todo segundo domingo de cada mês</div>
      </div>
      <div class="schedule-card bg-white p-9">
        <div class="s-day text-[13px] font-bold uppercase tracking-wider text-navy-light">Domingo · Noite</div>
        <div class="s-time font-display text-4xl font-bold text-navy my-3">19h30</div>
        <div class="s-desc text-[#6a6e9c] text-sm leading-relaxed">Copa Connect, toda última sexta-feira de cada mês</div>
      </div>
    </div>
</section>


<section id="sobre" class="py-28">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
    <div class="reveal aspect-square rounded-3xl bg-navy overflow-hidden relative">
      <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 w-full h-full">
        <g stroke="#ffffff" stroke-opacity="0.25" stroke-width="1.2">
          <line x1="70" y1="90" x2="200" y2="180"/>
          <line x1="200" y1="180" x2="330" y2="110"/>
          <line x1="200" y1="180" x2="150" y2="300"/>
          <line x1="200" y1="180" x2="300" y2="290"/>
          <line x1="150" y1="300" x2="300" y2="290"/>
          <line x1="70" y1="90" x2="330" y2="110"/>
        </g>
        <g>
          <circle cx="70" cy="90" r="6" fill="#ff751f"/>
          <circle cx="330" cy="110" r="5" fill="#ffffff" fill-opacity="0.8"/>
          <circle cx="200" cy="180" r="9" fill="#ff751f"/>
          <circle cx="150" cy="300" r="5" fill="#ffffff" fill-opacity="0.8"/>
          <circle cx="300" cy="290" r="6" fill="#ffffff" fill-opacity="0.8"/>
        </g>
      </svg>
    </div>

    <div class="reveal">
      <p class="font-display font-semibold text-navy text-2xl leading-snug mb-5">Connect não é só nome — é a proposta.</p>
      <p class="text-[#454877] text-[17px] leading-relaxed mb-5">
        Acreditamos que fé não foi feita pra ser vivida sozinha. O Culto Connect nasceu pra ser ponte: entre você e Deus, entre você e uma comunidade que te recebe sem julgamento e caminha junto na vida real.
      </p>
      <p class="text-[#454877] text-[17px] leading-relaxed">
        Seja no templo, na célula da sua rua ou na transmissão ao vivo do seu quarto — o convite é o mesmo: se conecta com a gente.
      </p>

      <div class="grid grid-cols-2 gap-6 mt-9">
        <div class="border-l-[3px] border-orange pl-4">
          <b class="block font-display text-navy text-base">Presença</b>
          <span class="text-[#6a6e9c] text-[13.5px] leading-relaxed">Cultos presenciais toda semana, com espaço pra todas as idades.</span>
        </div>
        <div class="border-l-[3px] border-orange pl-4">
          <b class="block font-display text-navy text-base">Comunidade</b>
          <span class="text-[#6a6e9c] text-[13.5px] leading-relaxed">Células e grupos pequenos espalhados pela cidade.</span>
        </div>
        <div class="border-l-[3px] border-orange pl-4">
          <b class="block font-display text-navy text-base">Online</b>
          <span class="text-[#6a6e9c] text-[13.5px] leading-relaxed">Transmissão ao vivo pra quem está longe ou de mudança.</span>
        </div>
        <div class="border-l-[3px] border-orange pl-4">
          <b class="block font-display text-navy text-base">Cuidado</b>
          <span class="text-[#6a6e9c] text-[13.5px] leading-relaxed">Aconselhamento e acompanhamento pastoral próximo.</span>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="aovivo" data-node="Ao vivo" class="relative overflow-hidden py-24 bg-gradient-to-br from-orange to-[#ff8c42]">
  <div class="absolute -right-10 -top-10 w-72 h-72 rounded-full border border-white/35"></div>
  <div class="absolute -right-32 -top-32 w-[420px] h-[420px] rounded-full border border-white/25"></div>

  <div class="relative z-10 max-w-6xl mx-auto px-6 lg:px-8 flex flex-wrap items-center justify-between gap-10">
    <div>
      <h2 class="font-display font-bold text-white text-3xl sm:text-4xl lg:text-[42px] leading-tight max-w-lg">
        Não pôde vir? A gente leva o culto até você.
      </h2>
      <p class="mt-4 text-white/85 max-w-md text-base">
        Transmissão ao vivo todo domingo, com chat aberto pra você orar e interagir com a igreja em tempo real.
      </p>
    </div>
    <a href="https://www.youtube.com/c/PIBEmSaracuruna" class="inline-flex items-center gap-2 rounded-full bg-white text-orange font-bold px-8 py-4 hover:-translate-y-0.5 transition whitespace-nowrap">
      ▶ Assistir agora
    </a>
  </div>
</section>


<section id="local" data-node="Local" class="py-28 bg-navy-dark">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="reveal max-w-xl mb-16">
      <span class="block text-orange text-[13px] font-bold uppercase tracking-widest mb-3">Onde estamos</span>
      <h2 class="font-display font-bold text-white text-3xl sm:text-4xl lg:text-5xl leading-tight">Vem pra perto.</h2>
      <p class="mt-4 text-white/60 text-lg leading-relaxed">Um endereço fácil de chegar e fácil de se sentir em casa.</p>
    </div>

    <div class="reveal grid lg:grid-cols-2 gap-4">
      <div class="bg-navy rounded-2xl p-11">
        <h3 class="text-white text-xl font-display font-bold mb-6">Templo Culto Connect</h3>

        <div class="flex gap-4 py-4">
          <div class="w-9 h-9 rounded-[10px] bg-orange/20 flex items-center justify-center shrink-0"><i class="fa-solid fa-location-dot text-address"></i></div>
          <div>
            <b class="block text-white text-sm">Endereço</b>
            <span class="text-white/55 text-[13.5px]">Av. Barão do Rio Branco 526 Saracuruna, D.Caxias</span>
          </div>
        </div>
        <div class="flex gap-4 py-4 border-t border-white/10">
          <div class="w-9 h-9 rounded-[10px] bg-orange/20 flex items-center justify-center shrink-0"><i class="fa-brands fa-whatsapp text-whatsapp"></i></div>
          <div>
            <b class="block text-white text-sm">Atendimento</b>
            <span class="text-white/55 text-[13.5px]">Fernado - (21) 999574-2765</span>
          </div>
        </div>
        <div class="flex gap-4 py-4 border-t border-white/10">
          <div class="w-9 h-9 rounded-[10px] bg-orange/20 flex items-center justify-center shrink-0"><i class="fa-solid fa-at text-white"></i></i></div>
          <div>
            <b class="block text-white text-sm">Contato</b>
            <span class="text-white/55 text-[13.5px]">Pibsconnect@gmail.com</span>
          </div>
        </div>
        <div class="flex gap-4 py-4 border-t border-white/10">
          <div class="w-9 h-9 rounded-[10px] bg-orange/20 flex items-center justify-center shrink-0"><i class="fa-solid fa-car-side text-orange"></i></div>
          <div>
            <b class="block text-white text-sm">Estacionamento</b>
            <span class="text-white/55 text-[13.5px]">Gratuito para membros e visitantes</span>
          </div>
        </div>
      </div>

      <div class="rounded-2xl overflow-hidden min-h-[340px] bg-navy-light relative" style="background-image:radial-gradient(circle at 30% 30%, rgba(255,117,31,0.35), transparent 45%);">
        <svg viewBox="0 0 300 340" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
          <g stroke="#ffffff" stroke-opacity="0.18" stroke-width="1">
            <line x1="0" y1="60" x2="300" y2="60"/>
            <line x1="0" y1="140" x2="300" y2="140"/>
            <line x1="0" y1="220" x2="300" y2="220"/>
            <line x1="80" y1="0" x2="80" y2="340"/>
            <line x1="200" y1="0" x2="200" y2="340"/>
          </g>
          <circle cx="150" cy="150" r="10" fill="#ff751f"/>
          <circle cx="150" cy="150" r="24" fill="none" stroke="#ff751f" stroke-opacity="0.5" stroke-width="2"/>
          <circle cx="150" cy="150" r="42" fill="none" stroke="#ff751f" stroke-opacity="0.25" stroke-width="2"/>
        </svg>
      </div>
    </div>
  </div>
</section>


<footer class="bg-navy-dark border-t border-white/10 pt-14 pb-9">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="flex flex-wrap justify-between items-start gap-8 pb-9 border-b border-white/10">
      <div>
        <div class="font-display font-extrabold text-xl text-white">CULTO<span class="text-orange">CONNECT</span></div>
        <p class="text-white/50 text-sm mt-2 max-w-xs leading-relaxed">Fé que conecta pessoas — presencial ou de onde você estiver.</p>
      </div>
      <div class="flex gap-3">
        <a href="https://www.instagram.com/pib.saracuruna/" aria-label="Instagram" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-orange hover:border-orange transition"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://www.youtube.com/c/PIBEmSaracuruna" aria-label="YouTube" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-orange hover:border-orange transition"><i class="fa-brands fa-youtube"></i></a>
        <a href="#" aria-label="WhatsApp" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-orange hover:border-orange transition"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>
    <div class="pt-6 flex flex-wrap justify-between gap-2 text-white/40 text-[13px]">
      <span>© 2026 Culto Connect. Todos os direitos reservados.</span>
      <span>Av. Barão do Rio Branco 526 Saracuruna, D.Caxias</span>
    </div>
  </div>
</footer>

<script>

document.getElementById('menuBtn').addEventListener('click', () => {
  document.getElementById('mobileMenu').classList.toggle('hidden');
});

(function(){
  const canvas = document.getElementById('network-canvas');
  const ctx = canvas.getContext('2d');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let w, h, nodes;

  function resize(){
    w = canvas.width = canvas.offsetWidth * devicePixelRatio;
    h = canvas.height = canvas.offsetHeight * devicePixelRatio;
  }
  function initNodes(){
    const count = Math.min(38, Math.floor((canvas.offsetWidth * canvas.offsetHeight) / 26000));
    nodes = Array.from({length: count}, () => ({
      x: Math.random() * w,
      y: Math.random() * h,
      vx: (Math.random() - 0.5) * 0.25 * devicePixelRatio,
      vy: (Math.random() - 0.5) * 0.25 * devicePixelRatio,
      r: (Math.random() * 1.6 + 1) * devicePixelRatio,
      accent: Math.random() < 0.12
    }));
  }
  function step(){
    ctx.clearRect(0,0,w,h);
    const maxDist = 150 * devicePixelRatio;
    for(let i=0;i<nodes.length;i++){
      const n = nodes[i];
      if(!reduceMotion){
        n.x += n.vx; n.y += n.vy;
        if(n.x < 0 || n.x > w) n.vx *= -1;
        if(n.y < 0 || n.y > h) n.vy *= -1;
      }
    }
    for(let i=0;i<nodes.length;i++){
      for(let j=i+1;j<nodes.length;j++){
        const a = nodes[i], b = nodes[j];
        const dx = a.x - b.x, dy = a.y - b.y;
        const dist = Math.sqrt(dx*dx + dy*dy);
        if(dist < maxDist){
          const alpha = (1 - dist / maxDist) * 0.35;
          ctx.strokeStyle = `rgba(255,255,255,${alpha})`;
          ctx.lineWidth = 1;
          ctx.beginPath();
          ctx.moveTo(a.x, a.y);
          ctx.lineTo(b.x, b.y);
          ctx.stroke();
        }
      }
    }
    for(const n of nodes){
      ctx.beginPath();
      ctx.arc(n.x, n.y, n.r, 0, Math.PI*2);
      ctx.fillStyle = n.accent ? '#ff751f' : 'rgba(255,255,255,0.8)';
      ctx.fill();
    }
    if(!reduceMotion) requestAnimationFrame(step);
  }
  function start(){ resize(); initNodes(); step(); }
  window.addEventListener('resize', () => { resize(); initNodes(); if(reduceMotion) step(); });
  start();
})();


(function(){
  const svg = document.getElementById('thread-svg');
  const sections = document.querySelectorAll('[data-node]');
  if(!svg || sections.length === 0) return;

  const ns = 'http://www.w3.org/2000/svg';
  const baseLine = document.createElementNS(ns, 'line');
  baseLine.setAttribute('x1','7'); baseLine.setAttribute('x2','7');
  baseLine.setAttribute('y1','0'); baseLine.setAttribute('y2','100%');
  svg.appendChild(baseLine);

  const fillLine = document.createElementNS(ns, 'line');
  fillLine.classList.add('fill-line');
  fillLine.setAttribute('x1','7'); fillLine.setAttribute('x2','7');
  fillLine.setAttribute('y1','0'); fillLine.setAttribute('y2','0');
  svg.appendChild(fillLine);

  const dots = [];
  sections.forEach(sec => {
    const dot = document.createElementNS(ns, 'circle');
    dot.classList.add('thread-node');
    dot.setAttribute('cx','7');
    dot.setAttribute('r','4');
    svg.appendChild(dot);
    dots.push({el: dot, sec});
  });

  function positionDots(){
    dots.forEach(d => {
      const rect = d.sec.getBoundingClientRect();
      const centerY = rect.top + rect.height * 0.18;
      d.el.setAttribute('cy', centerY);
      d.el._absY = centerY + window.scrollY;
    });
  }
  function updateFill(){
    const scrollCenter = window.scrollY + window.innerHeight * 0.5;
    let activeIdx = -1;
    dots.forEach((d, i) => {
      if(d.el._absY <= scrollCenter){ d.el.classList.add('active'); activeIdx = i; }
      else { d.el.classList.remove('active'); }
    });
    const y2 = activeIdx >= 0 ? dots[activeIdx].el.getAttribute('cy') : 0;
    fillLine.setAttribute('y2', y2);
  }
  window.addEventListener('resize', () => { positionDots(); updateFill(); });
  window.addEventListener('scroll', updateFill);
  positionDots();
  updateFill();
})();


(function(){
  const items = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('in'); });
  }, {threshold:0.15});
  items.forEach(i => io.observe(i));
})();
</script>

</body>
</html>
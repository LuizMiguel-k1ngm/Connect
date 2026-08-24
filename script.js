document.getElementById("menuBtn").addEventListener("click", () => {
  document.getElementById("mobileMenu").classList.toggle("hidden");
});

(function () {
  const canvas = document.getElementById("network-canvas");
  const ctx = canvas.getContext("2d");
  const reduceMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  let w, h, nodes;

  function resize() {
    w = canvas.width = canvas.offsetWidth * devicePixelRatio;
    h = canvas.height = canvas.offsetHeight * devicePixelRatio;
  }

  function initNodes() {
    const count = Math.min(
      38,
      Math.floor((canvas.offsetWidth * canvas.offsetHeight) / 26000),
    );
    nodes = Array.from(
      {
        length: count,
      },
      () => ({
        x: Math.random() * w,
        y: Math.random() * h,
        vx: (Math.random() - 0.5) * 0.25 * devicePixelRatio,
        vy: (Math.random() - 0.5) * 0.25 * devicePixelRatio,
        r: (Math.random() * 1.6 + 1) * devicePixelRatio,
        accent: Math.random() < 0.12,
      }),
    );
  }

  function step() {
    ctx.clearRect(0, 0, w, h);
    const maxDist = 150 * devicePixelRatio;
    for (let i = 0; i < nodes.length; i++) {
      const n = nodes[i];
      if (!reduceMotion) {
        n.x += n.vx;
        n.y += n.vy;
        if (n.x < 0 || n.x > w) n.vx *= -1;
        if (n.y < 0 || n.y > h) n.vy *= -1;
      }
    }
    for (let i = 0; i < nodes.length; i++) {
      for (let j = i + 1; j < nodes.length; j++) {
        const a = nodes[i],
          b = nodes[j];
        const dx = a.x - b.x,
          dy = a.y - b.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < maxDist) {
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
    for (const n of nodes) {
      ctx.beginPath();
      ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
      ctx.fillStyle = n.accent ? "#ff751f" : "rgba(255,255,255,0.8)";
      ctx.fill();
    }
    if (!reduceMotion) requestAnimationFrame(step);
  }

  function start() {
    resize();
    initNodes();
    step();
  }
  window.addEventListener("resize", () => {
    resize();
    initNodes();
    if (reduceMotion) step();
  });
  start();
})();

(function () {
  const svg = document.getElementById("thread-svg");
  const sections = document.querySelectorAll("[data-node]");
  if (!svg || sections.length === 0) return;

  const ns = "http://www.w3.org/2000/svg";
  const baseLine = document.createElementNS(ns, "line");
  baseLine.setAttribute("x1", "7");
  baseLine.setAttribute("x2", "7");
  baseLine.setAttribute("y1", "0");
  baseLine.setAttribute("y2", "100%");
  svg.appendChild(baseLine);

  const fillLine = document.createElementNS(ns, "line");
  fillLine.classList.add("fill-line");
  fillLine.setAttribute("x1", "7");
  fillLine.setAttribute("x2", "7");
  fillLine.setAttribute("y1", "0");
  fillLine.setAttribute("y2", "0");
  svg.appendChild(fillLine);

  const dots = [];
  sections.forEach((sec) => {
    const dot = document.createElementNS(ns, "circle");
    dot.classList.add("thread-node");
    dot.setAttribute("cx", "7");
    dot.setAttribute("r", "4");
    svg.appendChild(dot);
    dots.push({
      el: dot,
      sec,
    });
  });

  function positionDots() {
    dots.forEach((d) => {
      const rect = d.sec.getBoundingClientRect();
      const centerY = rect.top + rect.height * 0.18;
      d.el.setAttribute("cy", centerY);
      d.el._absY = centerY + window.scrollY;
    });
  }

  function updateFill() {
    const scrollCenter = window.scrollY + window.innerHeight * 0.5;
    let activeIdx = -1;
    dots.forEach((d, i) => {
      if (d.el._absY <= scrollCenter) {
        d.el.classList.add("active");
        activeIdx = i;
      } else {
        d.el.classList.remove("active");
      }
    });
    const y2 = activeIdx >= 0 ? dots[activeIdx].el.getAttribute("cy") : 0;
    fillLine.setAttribute("y2", y2);
  }
  window.addEventListener("resize", () => {
    positionDots();
    updateFill();
  });
  window.addEventListener("scroll", updateFill);
  positionDots();
  updateFill();
})();

(function () {
  const items = document.querySelectorAll(".reveal");
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) e.target.classList.add("in");
      });
    },
    {
      threshold: 0.15,
    },
  );
  items.forEach((i) => io.observe(i));
})();

# Tema-filho "Neon Cyberpunk" para o portfólio v2

**Data:** 2026-08-31
**Status:** Aprovado para implementação
**Escopo:** Reskin visual do tema `leo-nunes-portfolio-dinamico-v4`, via tema-filho, sem alterar templates PHP, campos ACF, CPTs ou dados.

## Contexto

O tema v2 (`leo-nunes-portfolio-dinamico-v4`) está em produção em `https://leonunesweb.com.br`, baseado no template Bootstrap 5 "iPortfolio" (AOS, typed.js, GLightbox, Swiper, Isotope, PureCounter). O objetivo é dar um visual mais moderno/futurista, mantendo 100% da estrutura de seções, campos ACF e CPTs (`portfolio`, `depoimento`, `servico`, `formacao`, `experiencia`) já em uso.

## Objetivo

Entregar um visual "Cyberpunk / Neon Dark" testável com um clique (ativar/desativar tema), sem qualquer risco para o tema v2 em produção, reaproveitando toda a base Bootstrap e o HTML/PHP existentes.

## Decisões de design (validadas com o usuário via companheiro visual)

### Direção visual
**Cyberpunk / Neon Dark** — fundo bem escuro, textos com glow neon, tipografia com um acento monoespaçado, sem exageros (grade técnica sutil no hero, sem partículas).

### Paleta
- Fundo primário: `#0a0a12`
- Fundo secundário (cards/seções alternadas): `#12121c`
- Destaque primário: ciano `#00ffe0` (títulos, links, foco, ícones)
- Destaque secundário: magenta `#ff2ee6` (gradientes, hover, detalhes — uso moderado)
- Texto principal: `#f5f5fa`
- Texto secundário: `#9aa0b4`
- Gradiente de assinatura: `linear-gradient(90deg, #00ffe0, #ff2ee6)` (usado em botões, sublinhados, barras de skill, timeline)

### Tipografia (Google Fonts)
- Títulos: **Space Grotesk** (700/800)
- Corpo de texto: **Inter** (400/500) — mais legível que Space Grotesk em parágrafos
- Acentos "código" (texto animado do hero, labels de categoria do portfólio, badges, copyright do footer): **JetBrains Mono**

### Nível de animação
**Sutil** — mantém AOS (scroll fade/slide) como está, glow discreto em hover/foco, grade técnica de baixa opacidade no hero. Sem partículas, sem glitch pesado, sem cursor customizado.

### Modo de cor
Sempre escuro (sem toggle claro/escuro).

## Abordagem de implementação: tema-filho

Em vez de editar o tema v2 diretamente, criar um **tema-filho** WordPress:

```
wp-content/themes/leo-nunes-portfolio-neon/
├── style.css        (cabeçalho do tema-filho, Template: leo-nunes-portfolio-dinamico-v4)
├── functions.php    (enfileira CSS do pai + os 2 CSS novos + fontes Google)
└── assets/
    └── css/
        ├── theme-tokens.css   (variáveis :root — cores, fontes, sombras/glow)
        └── neon-theme.css     (estilos visuais por componente, ver abaixo)
```

- **Nenhum arquivo do tema v2 é alterado.** Templates PHP, `inc/acf-fields.php`, `inc/cpt.php` etc. continuam exatamente como estão — o tema-filho herda tudo isso automaticamente do WordPress.
- **Ativação/teste:** Aparência → Temas → Ativar "Léo Nunes Portfólio Neon" (local ou produção). Reverter é ativar o v2 de novo — um clique, sem FTP, sem tocar em código.
- **Deploy:** copiar a pasta `leo-nunes-portfolio-neon` inteira via FTP para `wp-content/themes/` do servidor quando aprovado localmente. Não requer nova exportação/importação de banco nem reenvio de mídia — dados e uploads já são os mesmos usados pelo tema pai.

## Tratamento visual por seção

| Seção | Tratamento |
|---|---|
| Header/Nav (sticky) | Fundo `#0a0a12` translúcido + blur ao rolar; nome/logo com glow ciano; item de menu ativo com sublinhado em gradiente. |
| Hero | Grade técnica sutil de fundo; nome com glow; texto animado (typed.js) em JetBrains Mono com cursor ciano; CTAs com borda neon, preenchem no hover. |
| Sobre mim | Foto com borda fina em gradiente (estilo "moldura de scanner"); ícones das infos em ciano. |
| Estatísticas | Números grandes em Space Grotesk com glow; ícone acima em ciano. |
| Skills | Barras com preenchimento em gradiente ciano→magenta e glow na ponta. |
| Portfólio (Isotope + GLightbox) | Cards em `#12121c`, borda acende em ciano no hover; filtros de categoria com item ativo em glow. Comportamento de filtro/lightbox inalterado. |
| Resumo/Currículo | Timeline com marcadores em ciano conectados por linha em gradiente. |
| Serviços | Cards com ícone em destaque neon e borda que acende no hover (consistente com Portfólio). |
| Depoimentos (Swiper) | Cards em `#12121c`, aspas decorativas em magenta, paginação (dots) recolorida para ciano. Comportamento do carrossel inalterado. |
| Contato (formulário) | Inputs com fundo escuro, borda ciano com glow no foco; botão de envio no gradiente padrão. |
| Footer | Fundo mais escuro; ícones sociais com glow ciano no hover; copyright em JetBrains Mono. |

## Fora de escopo

- Qualquer alteração em templates PHP, `inc/*.php`, campos ACF ou CPTs.
- Reestruturação de seções (remover, juntar ou reordenar).
- Modo claro/escuro alternável.
- Efeitos pesados (partículas, glitch forte, cursor customizado).
- Alterações de banco de dados ou mídia — reaproveita o que já está em produção.

## Plano de testes

1. Implementar e revisar localmente (XAMPP) antes de qualquer envio à produção.
2. Rolar a Home inteira conferindo todas as seções da tabela acima.
3. Conferir ao menos um item de cada CPT (Portfólio, Depoimento, Serviço, Formação, Experiência), já que header/footer/tipografia mudam globalmente.
4. Checar contraste de texto (ciano/magenta sobre fundo escuro) para leitura confortável.
5. Testar responsivo (mobile/tablet) no navegador.
6. Confirmar que Isotope (filtro de portfólio), GLightbox (lightbox), Swiper (depoimentos) e o formulário de contato continuam funcionando normalmente — só o CSS muda, mas testar clique a clique.
7. Só após aprovação visual local, copiar a pasta do tema-filho para produção via FTP e ativar por lá do mesmo jeito.

## Rollback

Em qualquer ambiente (local ou produção), desativar é reativar o tema v2 original em Aparência → Temas. Nenhum dado, upload ou configuração é alterado pelo tema-filho, então a reversão é instantânea e sem risco.

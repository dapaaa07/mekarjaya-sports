---
version: "alpha"
name: "De Stijl Abstrato"
description: "De Stijl abstract design system applied to SSB Mekar Jaya Subang. Crisp white canvas structured by bold off-black grid lines, asymmetrical primary color blocks (#FF0000, #0000FF, #FFFF00), sharp 0px corners, and high-contrast Swiss Helvetica + JetBrains Mono typography."
dial: "ENERGY 3 / RHYTHM 3 / MOTION 2"
colors:
  primary: "#FF0000"
  secondary: "#0000FF"
  tertiary: "#FFFF00"
  neutral: "#111111"
  ink-on-red: "#000000"
  ink-red-on-white: "#CC0000"
  surface: "#FFFFFF"
  surface-muted: "#F4F4F4"
  accent-muted: "#525252"
  accent-dark-muted: "#D4D4D4"
typography:
  h1:
    fontFamily: "'Helvetica Neue', Helvetica, Arial, sans-serif"
    fontSize: 2.25rem
    fontWeight: 700
  body-md:
    fontFamily: "'Helvetica Neue', Helvetica, Arial, sans-serif"
    fontSize: 1rem
    fontWeight: 400
  mono:
    fontFamily: "'JetBrains Mono', monospace"
spacing:
  sm: 10.0px
  md: 20.0px
  lg: 40.0px
components:
  button-primary:
    backgroundColor: "#FF0000"
    hoverBackgroundColor: "#EB0000"
    textColor: "#000000"
    border: "2px solid #111111"
    borderRadius: "0px"
    padding: "12px 20px"
  button-blue:
    backgroundColor: "#0000FF"
    hoverBackgroundColor: "#0000D6"
    textColor: "#FFFFFF"
    border: "2px solid #111111"
    borderRadius: "0px"
  button-yellow:
    backgroundColor: "#FFFF00"
    hoverBackgroundColor: "#E6E600"
    textColor: "#111111"
    border: "2px solid #111111"
    borderRadius: "0px"
---

## Overview & Resolved Design Direction

- **Movement & Structure:** De Stijl / Neoplasticism (Utrecht, 1917). Strict horizontals and verticals dividing the `#FFFFFF` structural canvas using bold `#111111` grid rules (`border-2`).
- **Resolved Shape Override (Approved by User):** **Sharp corners (`0px`)** applied strictly across all cards, buttons, badges, inputs, modals, and photo frames to uphold "No curves, sharp corners" throughout public and admin surfaces.
- **Resolved Contrast Rules (WCAG AA/AAA Verified):**
  - On `#FF0000` (Primary Red): use `#000000` ink (`5.25:1`, hover `#EB0000` `4.53:1`). Never place small white text on `#FF0000`.
  - On `#0000FF` (Primary Blue): use `#FFFFFF` text (`8.59:1`).
  - On `#FFFF00` (Primary Yellow): use `#111111` text (`17.58:1`).
  - Secondary text on `#FFFFFF`: `#525252` (`7.81:1`) instead of `#808080` (`3.95:1` fail).
  - Dark structural canvas: `#111111` charcoal off-black with `#FFFFFF` (`18.88:1`) and `#D4D4D4` (`12.74:1`) / `#FFFF00` (`17.58:1`) ink.
  - Red inline ink on `#FFFFFF`: `#CC0000` (`5.89:1`) instead of `#FF0000` (`4.00:1` fail).
- **Layout & Rhythm (`RHYTHM 3`):** Asymmetric CSS Grid compositions across Hero, Roster, Age Categories, Staff Coaches, Dark Mini Soccer matrix, Registration Form, and Footer. Zero 3-equal-column feature blocks (`No 3-column equal-width feature layouts`).
- **Scope:** Full **De Stijl Abstrato** light canvas with bold grid lines and primary blocks across all public pages (Landing Page, Parent Portal, Admin Login) plus aligned styling across the Admin Portal workspace.

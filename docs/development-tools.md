# Development Tools Guide

This document provides an overview of the key VS Code extensions configured for this project's Dev Container. These tools are automatically installed when you open the project in the container.

---

## AI Assistant: Windsurf (formerly Codeium)

- **Extension ID:** `Codeium.codeium`
- **Website:** [https://www.windsurf.ai/](https://www.windsurf.ai/)

This is a free, AI-powered toolkit that acts as a pair programmer. Its primary purpose is to accelerate development by generating code, comments, and documentation.

### Key Features
- **AI Autocomplete:** Provides single and multi-line code completions as you type.
- **Integrated Chat:** Allows you to ask coding questions, refactor code, or ask for explanations directly within the VS Code editor, similar to ChatGPT.
- **Language Support:** Works with over 70 languages, including PHP.

### Toggling On and Off

You can easily enable or disable the extension as needed:

1.  **Via the Status Bar (Recommended):**
    - Look for the Windsurf/Codeium icon in the status bar at the bottom of the VS Code window.
    - Click it to open a menu with options to `Enable` or `Disable` the tool.

2.  **Via the Command Palette:**
    - Open the Command Palette (`Ctrl+Shift+P` or `Cmd+Shift+P`).
    - Type `Codeium` (the command name may not have updated to Windsurf yet) and select `Enable Completions` or `Disable Completions`.

---

## PHP Language Server: PHP Intelephense

- **Extension ID:** `bmewburn.vscode-intelephense-client`

This is the most important extension for PHP development. It acts as the "brain" that understands your code and provides core language features.

### Key Features
- **Intelligent Code Completion:** Autocompletes variables, methods, and classes.
- **Error Highlighting:** Detects and highlights errors in your code as you type.
- **Go-to-Definition:** Allows you to jump directly to the definition of a function or class.
- **PHPDoc Generation:** Automatically creates documentation blocks. Just type `/**` on the line above a function and press `Enter`.

---

## Debugger: PHP Debug Support

- **Extension ID:** `xdebug.php-debug`

This extension integrates the Xdebug PHP debugger directly into VS Code, allowing you to debug your code step-by-step.

### Key Features
- Set breakpoints to pause code execution at specific lines.
- Inspect the value of variables at any point during execution.
- Step through your code line-by-line to trace its logic.

**Note:** For this to function, the Xdebug PHP extension must also be installed in our Docker container. We can add this to the `Dockerfile` when you are ready to set up debugging.

---

## Utility: PHP Namespace Resolver

- **Extension ID:** `MehediDracula.php-namespace-resolver`

A simple but powerful utility that saves a lot of time when dealing with PHP namespaces.

### Key Features
- **Import Class:** Right-click on a class name and choose "Import Class" to automatically add the `use` statement to the top of your file.
- **Sort Imports:** Automatically organizes and sorts your `use` statements alphabetically.

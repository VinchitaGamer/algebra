<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Método de Gauss, Ecuaciones de Primer Grado y Newton-Raphson</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Estilos generales */
    body {
      background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h1, h2, h3 {
      text-align: center;
      color: #1d3557;
    }
    p {
      text-align: center;
      font-size: 1.1em;
      margin-bottom: 30px;
    }
    .input-container {
      margin-bottom: 20px;
    }
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }
    input[type="number"],
    input[type="text"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1em;
    }
    button {
      background-color: #457b9d;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1em;
      transition: background-color 0.3s ease;
      width: 100%;
      margin-bottom: 20px;
    }
    button:hover {
      background-color: #1d3557;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    td {
      padding: 5px;
    }
    input::placeholder {
      color: #888;
    }
    #resultado, #resultado-primergrado, #resultado-newton {
      margin-top: 10px;
    }
    #resultado ul, #resultado-primergrado ul, #resultado-newton ul {
      list-style: none;
      padding-left: 0;
    }
    #resultado li, #resultado-primergrado li, #resultado-newton li {
      background: #f1faee;
      margin-bottom: 5px;
      padding: 8px;
      border-left: 5px solid #457b9d;
      border-radius: 4px;
    }
    .section-divider {
      border-top: 2px solid #ccc;
      margin: 40px 0;
    }
    .note {
      background: #e7f5ff;
      border-left: 5px solid #457b9d;
      padding: 10px;
      margin-bottom: 20px;
      font-size: 0.95em;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Sección para Método de Gauss -->
    <h1>Método de Gauss</h1>
    <p>Resuelve un sistema de ecuaciones lineales utilizando matrices.</p>
    <div class="input-container">
      <label for="n">Número de incógnitas (N):</label>
      <input type="number" id="n" value="3" min="2" max="5">
    </div>
    <button onclick="crearMatrices()">Crear Matrices</button>
    <div id="matrices-container"></div>
    <button onclick="resolverSistema()">Resolver Sistema</button>
    <h3>Resultados:</h3>
    <div id="resultado"></div>

    <div class="section-divider"></div>

    <!-- Sección para Ecuación de Primer Grado -->
    <h2>Ecuación de Primer Grado</h2>
    <p>Resuelve ecuaciones de la forma <em>ax + b = 0</em>.</p>
    <div class="input-container">
      <label for="coeficienteA">Coeficiente (a):</label>
      <input type="number" id="coeficienteA" placeholder="Ingrese a" step="any">
    </div>
    <div class="input-container">
      <label for="terminoB">Término independiente (b):</label>
      <input type="number" id="terminoB" placeholder="Ingrese b" step="any">
    </div>
    <button onclick="resolverPrimerGrado()">Resolver Ecuación</button>
    <h3>Resultado:</h3>
    <div id="resultado-primergrado"></div>

    <div class="section-divider"></div>

    <!-- Sección para Método de Newton-Raphson -->
    <h2>Método de Newton-Raphson</h2>
    <p>Encuentra la raíz de una función <em>f(x)=0</em> utilizando Newton-Raphson.</p>
    <!-- Mensaje informativo para aclarar el uso de Math.pow -->
    <div class="note">
      <strong>Nota:</strong> Ingrese la función en formato JavaScript. Para representar potencias, utilice <code>Math.pow(x, n)</code> o el operador <code>**</code>. Por ejemplo, para <em>x³</em> use <code>Math.pow(x, 3)</code> o <code>x**3</code>, ya que <code>x^3</code> no realiza la operación de exponenciación.
    </div>
    <div class="input-container">
      <label for="funcion">Función f(x):</label>
      <input type="text" id="funcion" placeholder="Ejemplo: Math.pow(x,3) - x - 2">
    </div>
    <div class="input-container">
      <label for="derivada">Derivada f'(x):</label>
      <input type="text" id="derivada" placeholder="Ejemplo: 3*Math.pow(x,2) - 1">
    </div>
    <div class="input-container">
      <label for="inicial">Valor inicial (x₀):</label>
      <input type="number" id="inicial" placeholder="Ingrese x₀" step="any">
    </div>
    <div class="input-container">
      <label for="tolerancia">Tolerancia:</label>
      <input type="number" id="tolerancia" placeholder="Ejemplo: 0.0001" step="any">
    </div>
    <div class="input-container">
      <label for="maxIter">Máximo de iteraciones:</label>
      <input type="number" id="maxIter" placeholder="Ejemplo: 50">
    </div>
    <button onclick="resolverNewtonRaphson()">Resolver con Newton-Raphson</button>
    <h3>Resultado:</h3>
    <div id="resultado-newton"></div>
  </div>

  <script>
    let n = 3; // Número de incógnitas (por defecto)
    let A = []; // Matriz de coeficientes
    let b = []; // Vector de resultados

    // Crear las matrices A y b para el método de Gauss
    function crearMatrices() {
      n = parseInt(document.getElementById("n").value);
      A = [];
      b = [];
      let matricesContainer = document.getElementById("matrices-container");
      matricesContainer.innerHTML = ''; // Limpiar contenedor

      // Crear formulario para la matriz A y vector b
      let formHTML = `<h3>Matriz A (Coeficientes):</h3><table>`;
      for (let i = 0; i < n; i++) {
        formHTML += `<tr>`;
        for (let j = 0; j < n; j++) {
          formHTML += `<td><input type="number" id="a${i}${j}" placeholder="a${i+1}${j+1}" step="any"></td>`;
        }
        formHTML += `</tr>`;
      }
      formHTML += `</table><h3>Vector b (Resultados):</h3><table><tr>`;
      for (let i = 0; i < n; i++) {
        formHTML += `<td><input type="number" id="b${i}" placeholder="b${i+1}" step="any"></td>`;
      }
      formHTML += `</tr></table>`;
      matricesContainer.innerHTML = formHTML;
    }

    // Resolver el sistema de ecuaciones utilizando el método de Gauss
    function resolverSistema() {
      // Obtener los valores de la matriz A y el vector b
      for (let i = 0; i < n; i++) {
        A[i] = [];
        for (let j = 0; j < n; j++) {
          A[i][j] = parseFloat(document.getElementById(`a${i}${j}`).value);
        }
        b[i] = parseFloat(document.getElementById(`b${i}`).value);
      }
      // Aplicar el método de eliminación de Gauss
      let resultado = gaussElimination(A, b);
      mostrarResultado(resultado);
    }

    // Método de Gauss para resolver el sistema
    function gaussElimination(A, b) {
      for (let i = 0; i < n; i++) {
        // Hacer la diagonal de A[i][i] no nula
        for (let j = i + 1; j < n; j++) {
          if (A[j][i] !== 0) {
            let factor = A[j][i] / A[i][i];
            for (let k = i; k < n; k++) {
              A[j][k] -= factor * A[i][k];
            }
            b[j] -= factor * b[i];
          }
        }
      }
      // Sustitución hacia atrás
      let x = new Array(n);
      for (let i = n - 1; i >= 0; i--) {
        x[i] = b[i];
        for (let j = i + 1; j < n; j++) {
          x[i] -= A[i][j] * x[j];
        }
        x[i] /= A[i][i];
      }
      return x;
    }

    // Mostrar los resultados del método de Gauss en la página
    function mostrarResultado(resultado) {
      let resultadoContainer = document.getElementById("resultado");
      resultadoContainer.innerHTML = `<p><strong>Solución:</strong></p><ul>`;
      for (let i = 0; i < resultado.length; i++) {
        resultadoContainer.innerHTML += `<li>x${i+1} = ${resultado[i].toFixed(2)}</li>`;
      }
      resultadoContainer.innerHTML += `</ul>`;
    }

    // Resolver ecuación de primer grado: ax + b = 0
    function resolverPrimerGrado() {
      let a = parseFloat(document.getElementById("coeficienteA").value);
      let bTermino = parseFloat(document.getElementById("terminoB").value);
      let resultadoDiv = document.getElementById("resultado-primergrado");
      let solucion = '';

      if (isNaN(a) || isNaN(bTermino)) {
        solucion = 'Por favor, ingrese valores numéricos válidos para a y b.';
      } else if (a === 0) {
        if (bTermino === 0) {
          solucion = 'La ecuación tiene infinitas soluciones.';
        } else {
          solucion = 'La ecuación no tiene solución.';
        }
      } else {
        let x = -bTermino / a;
        solucion = `La solución es x = ${x.toFixed(2)}`;
      }
      resultadoDiv.innerHTML = `<ul><li>${solucion}</li></ul>`;
    }

    // Resolver ecuación utilizando el método de Newton-Raphson
    function resolverNewtonRaphson() {
      const fStr = document.getElementById("funcion").value;
      const dfStr = document.getElementById("derivada").value;
      const x0 = parseFloat(document.getElementById("inicial").value);
      const tol = parseFloat(document.getElementById("tolerancia").value);
      const maxIter = parseInt(document.getElementById("maxIter").value);
      const resultadoDiv = document.getElementById("resultado-newton");

      // Verificar entradas
      if (!fStr || !dfStr || isNaN(x0) || isNaN(tol) || isNaN(maxIter)) {
        resultadoDiv.innerHTML = `<ul><li>Por favor, ingrese todos los parámetros correctamente.</li></ul>`;
        return;
      }

      let f, df;
      try {
        // Se utiliza "with(Math)" para que se puedan usar funciones matemáticas sin prefijo.
        f = new Function("x", "with(Math){ return " + fStr + "; }");
        df = new Function("x", "with(Math){ return " + dfStr + "; }");
      } catch (error) {
        resultadoDiv.innerHTML = `<ul><li>Error en la función o derivada: ${error.message}</li></ul>`;
        return;
      }

      const result = newtonRaphson(f, df, x0, tol, maxIter);
      if (result.error) {
        resultadoDiv.innerHTML = `<ul><li>${result.error}</li></ul>`;
      } else {
        let mensaje = `Raíz aproximada: ${result.root.toFixed(6)} en ${result.iterations} iteraciones.`;
        if (!result.converged) {
          mensaje += " (No convergió completamente)";
        }
        resultadoDiv.innerHTML = `<ul><li>${mensaje}</li></ul>`;
      }
    }

    // Función que implementa el método de Newton-Raphson
    function newtonRaphson(f, df, x0, tol, maxIter) {
      let x = x0;
      for (let i = 0; i < maxIter; i++) {
        let fx = f(x);
        let dfx = df(x);
        if (Math.abs(fx) < tol) {
          return { root: x, iterations: i, converged: true };
        }
        if (dfx === 0) {
          return { error: "La derivada es cero. El método no converge." };
        }
        x = x - fx / dfx;
      }
      return { root: x, iterations: maxIter, converged: false };
    }

    // Crear las matrices al cargar la página
    window.onload = function() {
      crearMatrices();
    };
  </script>
</body>
</html>

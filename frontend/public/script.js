/* main start */
let currentStep = 1
const NR_OF_STEPS = 3

const prevStepButton = document.getElementById('previous-step-button')
const nextStepButton = document.getElementById('next-step-button')

let params = {}

prevStepButton.addEventListener('click', (e) => changeStep(e, -1));
nextStepButton.addEventListener('click', (e) => changeStep(e, 1));

updateUI(currentStep)

function changeStep(e, direction) {
    e.preventDefault();
    if (direction === 1 && !isFormValid(currentStep)) return;
    
    currentStep += direction;
    updateUI();
}

function updateUI() {
    refreshButtons(currentStep);
    refreshProgress(currentStep);
    refreshPanel(currentStep);
}

function clearValidationErrors(...elements) {
    elements.forEach(el => el.classList.remove('is-danger'));
}

function isFormValid(currentStep) {
    if (currentStep !== 2) return true;

    const ageInput = document.querySelector('input[name="age"]');
    const sexInputs = document.querySelectorAll('input[name="sex"]');
    const selectedSexInput = document.querySelector('input[name="sex"]:checked');

    clearValidationErrors(ageInput, ...sexInputs);

    if (ageInput.value.trim().length === 0 || ageInput.value.trim() < 60 || ageInput.value.trim() > 94) {
        ageInput.classList.add('is-danger');
        return false;
    }

    if (!selectedSexInput) {
        sexInputs.forEach(el => el.classList.add('is-danger'));
        return false;
    }

    params['age'] = ageInput.value;
    params['sex'] = selectedSexInput.value;

    return true;
}

function refreshPanel(currentStep) {
    const stepSelector = Array.from({ length: NR_OF_STEPS }, (_, i) => `.step-${i + 1}`).join(', ');
    document.querySelectorAll(stepSelector).forEach(el => {
        el.classList.toggle('is-hidden', !el.classList.contains(`step-${currentStep}`));
    });
}


function refreshProgress(currentStep) {
    document.querySelectorAll('ul.steps li.is-active').forEach(el => el.classList.remove('is-active'));
    const activeStep = document.querySelector(`ul.steps li:nth-child(${currentStep})`);
    if (activeStep) activeStep.classList.add('is-active');
}


function refreshButtons(currentStep) {
    if (!prevStepButton || !nextStepButton) return;
    
    prevStepButton.disabled = currentStep === 1;
    nextStepButton.disabled = currentStep === NR_OF_STEPS;
}

const buttons = document.querySelectorAll(".test .control button");

buttons.forEach((btn) => {
  btn.addEventListener("click", async function () {
    const parentCol = btn.closest("div.test");
    const resultInput = parentCol.querySelector('.control input');
    const resultBlock = parentCol.querySelector('div.block.result');

    resultBlock.querySelectorAll('.progress').forEach(el => el.remove());

    const resultValue = resultInput.value.trim();
    if (resultValue.length === 0) {
      resultInput.classList.add('is-danger');
      return;
    }

    const preloader = document.createElement('progress');
    preloader.classList.add('progress', 'is-large', 'is-primary');
    resultBlock.appendChild(preloader);

    resultInput.classList.remove('is-danger');

    params['test_code'] = parentCol.id
    params['result'] = resultInput.value
    
    console.log(params)
    
    const requestParams = new URLSearchParams(params);

    try {
      const response = await fetch(API_URL + '?' + requestParams, { method: 'GET' });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const data = await response.json();

      if (data && data.evaluation) {
        refreshResult(resultBlock, data);
      } else {
        console.error('Invalid data received from the server');
      }
    } catch (error) {
      console.error('Error during fetch:', error);
    } finally {
      preloader.remove();
    }
  });
});

function refreshResult(resultBlock, result) {
  resultBlock.querySelectorAll('.result, .progress').forEach(el => {
    el.classList.add('is-hidden');
    if (el.classList.contains('progress')) el.remove();
  });
  
  const resultMapping = {
    'below normal': '.result.below',
    'normal': '.result.normal',
    'above normal': '.result.above'
  };

  const evaluationSelector = resultMapping[result.evaluation];
  if (evaluationSelector) {
    resultBlock.querySelector(evaluationSelector).classList.remove('is-hidden');
  }

  resultBlock.querySelector('.result-description').classList.remove('is-hidden');
  resultBlock.querySelector('#lower-bound').textContent = result.min_ref;
  resultBlock.querySelector('#upper-bound').textContent = result.max_ref;
}
/* main end */

/* bulma modal */
function openModal($el) {
  $el.classList.add('is-active');
}

function closeModal($el) {
  $el.classList.remove('is-active');
}

function closeAllModals() {
  (document.querySelectorAll('.modal') || []).forEach(($modal) => {
    closeModal($modal);
  });
}

document.querySelectorAll('.js-modal-trigger').forEach(el => {
    const modal = el.closest('.columns').querySelector('.modal')
    el.addEventListener('click', function(_el) {
        _el.preventDefault()
        openModal(modal)
    });
});

document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button').forEach((el) => {
  const modal = el.closest('.modal');

  el.addEventListener('click', () => {
    closeModal(modal);
  });
});
/* bulma modal end */
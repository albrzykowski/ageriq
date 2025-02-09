let currentStep = 1
const NR_OF_STEPS = 3

const prevStepButton = document.getElementById('previous-step-button')
const nextStepButton = document.getElementById('next-step-button')

let params = {}

refreshButtons(currentStep)

prevStepButton.addEventListener('click', function(e) {
    e.preventDefault()
    currentStep -= 1
    refreshButtons(currentStep)
    refreshProgress(currentStep)
    refreshPanel(currentStep)
})

nextStepButton.addEventListener('click', function(e) {
    e.preventDefault()
    if (!isFormValid(currentStep)) {
      return false
    }
    currentStep += 1
    
    refreshButtons(currentStep)
    refreshProgress(currentStep)
    refreshPanel(currentStep)
})

function isFormValid(currentStep) {
  
  if (currentStep == 2) {
    const ageInput = document.querySelector('input[name="age"]')
    const sexInputs = document.querySelectorAll('input[name="sex"]')
    const selectedSexInput = document.querySelector('input[name="sex"]:checked')
    ageInput.classList.remove('is-danger')
    sexInputs.forEach((el) => {
      el.classList.remove('is-danger')
    })
    
    if (ageInput.value.trim().length == 0 || ageInput.value.trim() < 60 || ageInput.value.trim() > 94) {
      ageInput.classList.add('is-danger')
      return false
    }

    if (!selectedSexInput || !selectedSexInput.checked) {
      sexInputs.forEach((el) => {
        el.classList.add('is-danger')
      }) 
      return false
    }
    params['age'] = ageInput.value
    params['sex'] = selectedSexInput.value
  }
  
  return true
}

function refreshPanel(currentStep) {
  const stepsToHide = [1, 2, 3].filter(function(e) { return e !== currentStep })
  const toShow = document.querySelectorAll('.step-' + currentStep)
  
  toShow.forEach((el) => {
    el.classList.remove('is-hidden')
  })
  
  stepsToHide.forEach((el) => {
      const toHide = document.querySelectorAll('.step-' + el)
      toHide.forEach((_el) => {
        _el.classList.add('is-hidden')
      })
  })
}

function refreshProgress(currentStep) {
    const steps = document.querySelectorAll('ul.steps li')
    steps.forEach((step, i) => {
        if (i + 1 == currentStep) {
            step.classList.add('is-active')
            // step.querySelector('span.step-maker').classList.add('has-background-success')
        } else {
            step.classList.remove('is-active')
            // step.querySelector('span.step-maker').classList.remove('has-background-success')
        }
    })
}

function refreshButtons(currentStep) {
    if (currentStep == 1) {
        prevStepButton.disabled = true
    } else {
        prevStepButton.disabled = false
    }
    if (currentStep == NR_OF_STEPS) {
        nextStepButton.disabled = true
    } else {
        nextStepButton.disabled = false
    }
}

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

const buttons = document.querySelectorAll(".test .control button")
buttons.forEach((btn) => {
  btn.addEventListener("click", function () {
    const parentCol = btn.closest("div.test")
    const resultInput = parentCol.querySelector('.control input')
    const resultBlock = parentCol.querySelector('div.block.result')
    
    resultBlock.querySelectorAll('.progress').forEach(el => el.remove())
    
    params['test_code'] = parentCol.id
    params['result'] = resultInput.value
    
    if (resultInput.value.trim().length == 0) {
      resultInput.classList.add('is-danger')
      return
    }
    
    let preloader = document.createElement('progress')
    preloader.classList.add('progress')
    preloader.classList.add('is-large')
    preloader.classList.add('is-primary')
    resultBlock.appendChild(preloader)
    
    resultInput.classList.remove('is-danger')
    
    const requestParams = new URLSearchParams(params);

    fetch(API_URL + '?' + requestParams, {
      method: 'GET'
    }).then(response =>  response.json().then(data => refreshResult(resultBlock ,data)))
      .catch(error => console.error(error))
    })
  
})

function refreshResult(resultBlock, result) {
  resultBlock.querySelectorAll('.result').forEach((el) => el.classList.add('is-hidden'))
  resultBlock.querySelectorAll('.progress').forEach(el => el.remove())
  
  if (result.evaluation == 'below normal') {
    resultBlock.querySelector('.result.below').classList.remove('is-hidden')
  }
  if (result.evaluation == 'normal') {
    resultBlock.querySelector('.result.normal').classList.remove('is-hidden')
  }
  if (result.evaluation == 'above normal') {
    resultBlock.querySelector('.result.above').classList.remove('is-hidden')
  }
  resultBlock.querySelector('.result-description').classList.remove('is-hidden')
  resultBlock.querySelector('#lower-bound').textContent = result.min_ref
  resultBlock.querySelector('#upper-bound').textContent = result.max_ref
}
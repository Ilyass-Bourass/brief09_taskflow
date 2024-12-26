// Attendre que le document soit complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments
    const inscriptionModal = document.getElementById('inscriptionModal');
    const taskModal = document.getElementById('taskModal');
    const detailsModal = document.getElementById('detailsModal');
    const btnInscription = document.getElementById('btnInscription');
    const addTaskBtn = document.getElementById('addTaskBtn');
    const taskType = document.getElementById('taskType');
    const bugFields = document.getElementById('bugFields');
    const featureFields = document.getElementById('featureFields');

    // Ouvrir modal inscription
    btnInscription.onclick = function() {
        inscriptionModal.style.display = 'block';
    }

    // Ouvrir modal nouvelle tâche
    addTaskBtn.onclick = function() {
        taskModal.style.display = 'block';
    }

    // Ouvrir modal détails
    document.querySelectorAll('.details-link').forEach(link => {
        link.onclick = function(event) {
            event.preventDefault(); 
            event.stopPropagation(); 
            detailsModal.style.display = 'block';
            console.log('Click sur détails détecté');
        }
    });

    // Fermer les modals quand on clique en dehors
    window.onclick = function(event) {
        if (event.target == inscriptionModal || 
            event.target == taskModal || 
            event.target == detailsModal) {
            inscriptionModal.style.display = 'none';
            taskModal.style.display = 'none';
            detailsModal.style.display = 'none';
        }
    }

    // Afficher/masquer les champs selon le type de tâche
    if(taskType) {
        taskType.onchange = function() {
            bugFields.style.display = 'none';
            featureFields.style.display = 'none';
            
            if (this.value === 'bug') {
                bugFields.style.display = 'block';
            } else if (this.value === 'feature') {
                featureFields.style.display = 'block';
            }
        }
    }
}); 
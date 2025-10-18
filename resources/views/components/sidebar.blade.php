<nav class="sidebar" >
    <div class="sidebar-header">
        <div class="sidebar-logo">APIPA</div>
        <div class="sidebar-subtitle">Gestion des Remblais</div>
    </div>
    <div class="sidebar-menu">
        <button 
            class="menu-item" 
            :class="{ active: currentPage === 'dashboard' }"
            @click="navigateTo('dashboard')"
        >
            <i class="fas fa-chart-dashboard"></i>
            Dashboard
        </button>
        <button 
            class="menu-item" 
            :class="{ active: currentPage === 'demande-pc' }"
            @click="navigateTo('demande-pc')"
        >
            <i class="fas fa-file-alt"></i>
            Demande PC
        </button>
        <button 
            class="menu-item" 
            :class="{ active: currentPage === 'descentes' }"
            @click="navigateTo('descentes')"
        >
            <i class="fas fa-arrow-down"></i>
            Descentes
        </button>
        
        <button 
            class="menu-item" 
            :class="{ active: currentPage === 'autre' }"
            @click="navigateTo('autre')"
        >
            <i class="fas fa-ellipsis-h"></i>
            Autre
        </button>
        <button 
            class="menu-item" 
            :class="{ active: currentPage === 'apipa' }"
            @click="navigateTo('apipa')"
        >
            <i class="fas fa-ellipsis-h"></i>
            APIPA
        </button>
    </div>
</nav>
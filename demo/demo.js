'use strict';
// Vista previa: lógica del navegador (no sustituye controles de seguridad del servidor).
const KEY = 'systembomb-academic-demo-v2';
const seed = () => ({
  resources:[
    {id:1,code:'EPP-001',name:'Casco de protección',category:'EPP',location:'Almacén A',status:'disponible',quantity:12,min_stock:4,expires_at:''},
    {id:2,code:'EPP-002',name:'Botas de seguridad',category:'EPP',location:'Almacén A',status:'disponible',quantity:8,min_stock:3,expires_at:''},
    {id:3,code:'HER-001',name:'Hacha de rescate',category:'Herramientas',location:'Almacén B',status:'disponible',quantity:5,min_stock:2,expires_at:''},
    {id:4,code:'MAN-001',name:'Manguera 1.5 pulgadas',category:'Mangueras',location:'Almacén B',status:'disponible',quantity:4,min_stock:4,expires_at:''},
    {id:5,code:'INS-001',name:'Gasas estériles — DEMO',category:'Insumos médicos',location:'Depósito',status:'disponible',quantity:18,min_stock:8,expires_at:'2026-11-12'},
    {id:6,code:'HER-002',name:'Bomba hidráulica — DEMO',category:'Herramientas',location:'Taller',status:'mantenimiento',quantity:1,min_stock:1,expires_at:''}
  ],
  loans:[{id:1,resource_id:1,recipient:'Voluntario de prueba A',quantity:2,assigned_at:'2026-10-08',returned_at:''},{id:2,resource_id:3,recipient:'Voluntario de prueba B',quantity:1,assigned_at:'2026-10-07',returned_at:''}],
  vehicles:[{id:1,code:'UNI-01',type:'Unidad de rescate (DEMO)',status:'operativo',mileage:12000,next_maintenance_at:'2026-12-20'},{id:2,code:'UNI-02',type:'Unidad auxiliar (DEMO)',status:'mantenimiento',mileage:28000,next_maintenance_at:'2026-11-07'}]
});
function load(){try{let d=JSON.parse(localStorage.getItem(KEY));if(d&&Array.isArray(d.resources)&&Array.isArray(d.loans)&&Array.isArray(d.vehicles))return d;}catch(e){}return seed();}
let state=load();const $=s=>document.querySelector(s);const all=s=>document.querySelectorAll(s);
function save(){try{localStorage.setItem(KEY,JSON.stringify(state));}catch(e){/* El demo sigue funcionando aun si el navegador bloquea localStorage en archivos locales. */}}
const esc=v=>String(v??'').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'",'&#39;');
const fmtDate=s=>s?new Date(s+'T00:00:00').toLocaleDateString('es-PE'):'No registrada';
const available=r=>Math.max(0,r.quantity-state.loans.filter(l=>l.resource_id===r.id&&!l.returned_at).reduce((t,l)=>t+l.quantity,0));
const badge=s=>`<span class="status ${['disponible','operativo','devuelto'].includes(s)?'ok':['mantenimiento','en préstamo'].includes(s)?'pending':'off'}">${esc(s)}</span>`;
function message(text){const e=$('#toast');e.textContent=text;e.classList.add('visible');setTimeout(()=>e.classList.remove('visible'),2500);}
function nav(view){all('.view').forEach(e=>e.classList.toggle('hidden',e.id!==view));all('[data-view]').forEach(e=>e.classList.toggle('active',e.dataset.view===view));$('#breadcrumb').textContent=({panel:'Panel principal',inventario:'Inventario',asignaciones:'Asignaciones',vehiculos:'Unidades'})[view]||'Panel';$('#sidebar').classList.remove('sidebar-open');window.location.hash=view;render();}
function render(){
 const active=state.resources.filter(x=>x.status!=='baja'), low=active.filter(x=>available(x)<=x.min_stock), exp=active.filter(x=>x.expires_at && new Date(x.expires_at+'T00:00:00')<=new Date(Date.now()+30*86400000));
 $('#stats').innerHTML=[['▤','blue','Recursos activos',active.length,'Registros en el sistema'],['⇄','amber','Préstamos activos',state.loans.filter(l=>!l.returned_at).length,'Pendientes de devolución'],['!','rose','Alertas de stock',low.length,'Recursos en stock mínimo'],['🚒','green','Vehículos',state.vehicles.length,'Unidades registradas']].map(([ico,color,label,val,sub])=>`<article class="stat-card"><div class="stat-icon ${color}">${ico}</div><span>${label}</span><strong>${val}</strong><small>${sub}</small></article>`).join('');
 $('#alerts-count').textContent=`${low.length+exp.length} avisos`;
 $('#alerts').innerHTML=[...low.map(r=>`<div class="alert-row"><span class="alert-dot">!</span><div><strong>Stock bajo: ${esc(r.name)}</strong><small>Disponibles: ${available(r)} · Mínimo: ${r.min_stock}</small></div></div>`),...exp.map(r=>`<div class="alert-row"><span class="alert-dot orange">◷</span><div><strong>Fecha de vencimiento: ${esc(r.name)}</strong><small>${fmtDate(r.expires_at)}</small></div></div>`)].join('')||'<p class="empty">No hay alertas en este momento.</p>';
 $('#recent').innerHTML=state.loans.slice().sort((a,b)=>b.id-a.id).slice(0,5).map(l=>`<div class="movement"><div class="movement-symbol">⇄</div><div><strong>${esc(state.resources.find(r=>r.id===l.resource_id)?.name||'Recurso')}</strong><small>${esc(l.recipient)} · ${fmtDate(l.assigned_at)}</small></div>${badge(l.returned_at?'devuelto':'en préstamo')}</div>`).join('')||'<p class="empty">No hay movimientos.</p>';
 const q=$('#search').value.toLowerCase().trim(), filtered=state.resources.filter(r=>[r.code,r.name,r.category].join(' ').toLowerCase().includes(q));$('#record-count').textContent=filtered.length+' registros';
 $('#inventory-body').innerHTML=filtered.map(r=>`<tr><td><code>${esc(r.code)}</code></td><td><b>${esc(r.name)}</b><small class="subtext">Mínimo: ${r.min_stock}</small></td><td>${esc(r.category)}</td><td>${esc(r.location)}</td><td><b>${available(r)}</b> / ${r.quantity}</td><td>${badge(r.status)}</td><td><div class="actions"><button data-edit-resource="${r.id}">Editar</button>${r.status!=='baja'?`<button class="danger" data-off-resource="${r.id}">Baja</button>`:''}</div></td></tr>`).join('')||'<tr><td colspan="7" class="empty">Sin resultados.</td></tr>';
 $('#loans-body').innerHTML=state.loans.slice().sort((a,b)=>b.id-a.id).map(l=>`<tr><td><b>${esc(state.resources.find(r=>r.id===l.resource_id)?.name||'Recurso')}</b></td><td>${esc(l.recipient)}</td><td>${l.quantity}</td><td>${fmtDate(l.assigned_at)}</td><td>${badge(l.returned_at?'devuelto':'en préstamo')}</td><td>${l.returned_at?'—':`<button class="text-link" data-return="${l.id}">Devolver</button>`}</td></tr>`).join('')||'<tr><td colspan="6" class="empty">Sin movimientos.</td></tr>';
 $('#vehicles-body').innerHTML=state.vehicles.map(v=>`<tr><td><code>${esc(v.code)}</code></td><td><b>${esc(v.type)}</b></td><td>${badge(v.status)}</td><td>${Number(v.mileage).toLocaleString('es-PE')} km</td><td>${fmtDate(v.next_maintenance_at)}</td><td><button class="text-link" data-edit-vehicle="${v.id}">Editar</button></td></tr>`).join('');
}
const input=(name,label,value='',type='text',req='required')=>`<label>${label}<input name="${name}" type="${type}" ${req} value="${esc(value)}"></label>`;
const select=(name,label,options,value)=>`<label>${label}<select name="${name}" required>${options.map(x=>`<option value="${esc(x)}" ${x===value?'selected':''}>${esc(x)}</option>`).join('')}</select></label>`;
function openForm(kind,id=null){const r=kind==='resource'?state.resources.find(x=>x.id===id):kind==='vehicle'?state.vehicles.find(x=>x.id===id):null;const title={resource:'recurso',vehicle:'vehículo',loan:'préstamo'}[kind];$('#modal-title').textContent=(r?'Editar ':'Registrar ')+title;const f=$('#entry-form');f.dataset.kind=kind;f.dataset.id=id||'';
 let fields='';if(kind==='resource'){fields=[input('code','Código único *',r?.code),input('name','Nombre *',r?.name),select('category','Categoría *',['EPP','Herramientas','Mangueras','Insumos médicos','Otros'],r?.category),input('location','Ubicación *',r?.location),select('status','Estado *',['disponible','mantenimiento','baja'],r?.status),input('quantity','Unidades *',r?.quantity??1,'number'),input('min_stock','Stock mínimo *',r?.min_stock??1,'number'),input('expires_at','Vencimiento (opcional)',r?.expires_at,'date','')].join('');}
 if(kind==='vehicle'){fields=[input('code','Código *',r?.code),input('type','Tipo de unidad *',r?.type),select('status','Estado *',['operativo','mantenimiento','inactivo'],r?.status),input('mileage','Kilometraje *',r?.mileage??0,'number'),input('next_maintenance_at','Próximo mantenimiento',r?.next_maintenance_at,'date','')].join('');}
 if(kind==='loan'){fields=`<label class="full">Recurso disponible *<select name="resource_id" required>${state.resources.filter(r=>r.status==='disponible'&&available(r)>0).map(r=>`<option value="${r.id}">${esc(r.name)} (${available(r)} disponibles)</option>`).join('')}</select></label>`+input('recipient','Responsable / Receptor *','','text')+input('quantity','Cantidad *',1,'number');}
 $('#fields').innerHTML=fields;$('#form-dialog').showModal();}
$('#entry-form').addEventListener('submit',e=>{e.preventDefault();const f=e.currentTarget, fd=new FormData(f), kind=f.dataset.kind, id=Number(f.dataset.id), data=Object.fromEntries(fd.entries());
 if(kind==='resource'){data.quantity=Number(data.quantity);data.min_stock=Number(data.min_stock);if(data.quantity<0||data.min_stock<0){message('Las cantidades deben ser no negativas.');return;}if(state.resources.some(r=>r.code===data.code&&r.id!==id)){message('El código ya existe.');return;}const old=state.resources.find(x=>x.id===id);if(old && data.quantity<state.loans.filter(l=>l.resource_id===id&&!l.returned_at).reduce((t,l)=>t+l.quantity,0)){message('No puedes reducir unidades por debajo de préstamos activos.');return;}if(id)Object.assign(old,data);else state.resources.push({...data,id:Date.now()});}
 if(kind==='vehicle'){data.mileage=Number(data.mileage);if(data.mileage<0){message('Kilometraje inválido.');return;}if(state.vehicles.some(v=>v.code===data.code&&v.id!==id)){message('Ese código ya existe.');return;}if(id)Object.assign(state.vehicles.find(v=>v.id===id),data);else state.vehicles.push({...data,id:Date.now()});}
 if(kind==='loan'){data.resource_id=Number(data.resource_id);data.quantity=Number(data.quantity);const r=state.resources.find(x=>x.id===data.resource_id);if(!r||r.status!=='disponible'||data.quantity<1||data.quantity>available(r)||r.expires_at&&new Date(r.expires_at+'T00:00:00')<new Date()){message('No es posible asignar: revisa stock, estado y vencimiento.');return;}state.loans.push({...data,id:Date.now(),assigned_at:new Date().toISOString().slice(0,10),returned_at:''});}
 save();$('#form-dialog').close();render();message('Cambios guardados en esta vista previa.');});
document.addEventListener('click',e=>{let b=e.target.closest('button,a');if(!b)return;
 if(b.dataset.goto)nav(b.dataset.goto);
 if(b.dataset.view)nav(b.dataset.view);
 if(b.dataset.editResource)openForm('resource',Number(b.dataset.editResource));
 if(b.dataset.offResource){let id=Number(b.dataset.offResource),r=state.resources.find(x=>x.id===id);if(state.loans.some(l=>l.resource_id===id&&!l.returned_at)){message('Devuelve primero el equipo prestado.');return;}if(confirm('¿Dar de baja este recurso?')){r.status='baja';save();render();message('Recurso marcado como baja.');}}
 if(b.dataset.return){let loan=state.loans.find(x=>x.id===Number(b.dataset.return));if(loan&&!loan.returned_at){loan.returned_at=new Date().toISOString().slice(0,10);save();render();message('Devolución registrada.');}}
 if(b.dataset.editVehicle)openForm('vehicle',Number(b.dataset.editVehicle));
});
$('#new-resource').onclick=()=>openForm('resource');$('#new-loan').onclick=()=>openForm('loan');$('#new-vehicle').onclick=()=>openForm('vehicle');$('#search').oninput=render;$('#do-search').onclick=render;
$('#close-dialog').onclick=()=>$('#form-dialog').close();$('#cancel-dialog').onclick=()=>$('#form-dialog').close();
$('#reset').onclick=()=>{if(confirm('¿Restaurar los datos ficticios originales?')){state=seed();save();render();message('Datos restaurados.');}};
$('#menu-toggle').onclick=()=>$('#sidebar').classList.toggle('sidebar-open');
nav(['panel','inventario','asignaciones','vehiculos'].includes(location.hash.slice(1))?location.hash.slice(1):'panel');

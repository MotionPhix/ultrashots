import { Contact, ContactsData } from '@/types'
import axios from 'axios'
import { defineStore } from 'pinia'
import { reactive, ref, toRefs } from 'vue'

interface ContactState {
  selectedContacts: (string|undefined)[]
  baseGroup: ContactsData
}

export const useContactStore = defineStore('contacts', () => {
  const state: ContactState = reactive({
    selectedContacts: ref<(string|undefined)[]>([]),
    baseGroup: ref(),
  })

  const { ...reactiveState } = toRefs(state)

  async function fetchContacts(filter: string = ''): Promise<void> {
    // Fetch the latest contacts from the database
    const response = await axios.get(filter.length ? `/${filter}` : '/');
    state.baseGroup = response.data;
  }

  async function createOrUpdateContact(contact: Contact): Promise<void> {
    const group = generateGroup(contact);

    if (!state.baseGroup[group]) {
      state.baseGroup[group] = [];
    }

    const existingContactIndex = state.baseGroup[group].findIndex((c) => c.id === contact.id);

    if (existingContactIndex !== -1) {
      // Update existing contact
      state.baseGroup[group][existingContactIndex] = contact;
    } else {
      // Create new contact
      state.baseGroup[group].push(contact);
    }

    // Save to the database
    await axios.post('/store', contact);

    // Fetch the latest data from the database and update the store
    await fetchContacts();
  }

  async function updateContact(contact: Contact): Promise<void> {
    const group = generateGroup(contact);

    const existingContactIndex = state.baseGroup[group]?.findIndex((c) => c.id === contact.id);

    if (existingContactIndex !== undefined && existingContactIndex !== -1) {
      state.baseGroup[group][existingContactIndex] = contact;
    }

    // Update in the database
    await axios.put(`/update/${contact.cid}`, contact);

    // Fetch the latest data from the database and update the store
    await fetchContacts();
  }

  function setBaseGroup(base: ContactsData) {
    state.baseGroup = base
  }

  function setSelectedContacts(contact: string | undefined) {
    state.selectedContacts.push(contact)
  }

  function unsetSelectedContacts(contact: string | undefined) {
    state.selectedContacts = (state.selectedContacts.filter(activeId => activeId !== contact))
  }

  function expungeSelectedContacts() {
    state.selectedContacts = []
  }

  return { ...reactiveState, setSelectedContacts, unsetSelectedContacts, expungeSelectedContacts, setBaseGroup }
})

function generateGroup(contact: Contact): string {
  const firstNameInitial = contact.first_name[0].toUpperCase();
  const lastNameInitial = contact.last_name[0].toUpperCase();
  return `${firstNameInitial}${lastNameInitial}`;
}
